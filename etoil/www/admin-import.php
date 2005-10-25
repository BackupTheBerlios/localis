<?php
$title = "Gestion des utilisateurs";
$db = true;
$mod = false;
$feedback = $focus = array();
include("setup.php");
?>
<h2>Bienvenue sur la page d'importation directe des tracés</h2>
 <form method="post" action="admin-import.php">
<b>id de marquage de l'import <input type="text" name="marqimp" value="<?= date("dmy")?>"></b>
<h3>Actions disponibles:</h3>
<h4>Import du SIG Régional en shp</h4>
Opérations à réaliser pour un import Kayak du SIG Regional:<br><pre>
- Supprimer la table temporaire zimptmp_parc_kk
- exécuter les commandes
/usr/local/pgsql/bin/shp2pgsql Parcours.shp zimptmp_parc_kk > /tmp/zimptmp_parc_kk.sql
- puis (en user pguser)
psql etoil < /tmp/zimptmp_parc_kk.sql
</pre>
<input type="radio" name="actionname" value="impkksigrshp">Import Kayak SIG R (shp)<BR/>
<hr/>
<h4>Import du CPIE en shp</h4>
Opérations à réaliser pour un import du cpie :<br><pre>
- Supprimer la table temporaire zimptmp_iti_cpie
- exécuter les commandes
/usr/local/pgsql/bin/shp2pgsql itinéraire_polyline.shp zimptmp_iti_cpie > /tmp/zimptmp_iti_cpie.sql
puis (en user pguser)
psql etoil < /tmp/zimptmp_iti_cpie.sql
</pre>
<input type="radio" name="actionname" value="impcpie">Import CPIE<BR/>
<hr/>
<h4>Import Cyclotourisme CG19 </h4>
Opérations à réaliser pour un import cyclotourisme du cg19 :<br>
<pre>
- Supprimer la table temporaire zimptmp_ctcg19
- Pour convertir le mif en shp, exécuter la commande  
ogr2ogr -f "ESRI Shapefile" cg.shp N4_Meymac.MIF
- pour convertir le shp en postgis:
/usr/local/pgsql/bin/shp2pgsql cg.shp zimptmp_ctcg19 > zimptmp_ctcg19.sql
- puis (en user pguser)
psql etoil < /tmp/zimptmp_ctcg19.sql
<input type="radio" name="actionname" value="impctcg19">Import CycloTourisme CG19<BR/>
<input type="submit">
</form>
 
<?

/* !!!!!!!!!!!!!!!!!!!!!!!!!!!
! IMPORT KAYAK SIGR EN SHP !
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! */

if ($_REQUEST[actionname]=="impkksigrshp") {

/*champs Origines
gid 	objectid 	id_bdcarto 	largeur 	etat 	nature 	pos_sol 	top_c_eau 	long_km 	navigation 	restric 	classe 	niv_comp 	parcours 	shape_leng 	the_geom

parcours_id serial NOT NULL,
    parcours_name character varying(255),
    parcours_user character varying(255),
    parcours_level integer,
    parcours_length integer,
    parcours_discp character varying,
    parcours_geom geometry,
    parcours_start geometry,
    parcours_time integer,
    parcours_ttop character varying,
    parcours_desc text,
    parcours_ouvert boolean DEFAULT true,
    parcours_fermet_details text,
    parcours_fermet_point geometry,
    parcours_guides character varying,
    parcours_equipt character varying DEFAULT 1,
    parcours_interet character varying DEFAULT 1,
    parcours_topo text,
    parcours_photo character varying,
    parcours_balisage integer DEFAULT 1,
    parcours_valid integer DEFAULT 0,
    parcours_source integer DEFAULT 0,
    parcours_dtcrea timestamp without time zone,
    parcours_dtmaj timestamp without time zone,
    parcours_uscrea character varying,
    parcours_usmaj character varying,
    parcours_environmt character varying DEFAULT 1,
*/


	$parcours_discp="4"; // kayak
	$vitmoy=RecupLib("disciplines","disc_id","disc_vitmoy",$parcours_discp);
	$srcg_id=2; // SIGR_CK
	$usermajcartokksig="jy-jabet";
	echo "vitmoy: $vitmoy";

	echo "Import des tracés Kayak<BR/>";
	
	$qu_sel="select *,AsText(the_geom) from zimptmp_parc_kk order by parcours,gid";
	$rep=$db->s_query($qu_sel);
	while ($row=pg_fetch_assoc($rep)) {
		
	
		if ($row[parcours]!=$parcours_c) {
			if (isset($tbvc)) { // marche pas le 1er coup fait expres		
				$req_ins="insert into parcours (
				parcours_name,
				parcours_user,
				parcours_discp,
				parcours_geom,
				parcours_desc,
				parcours_source,
				parcours_idsource,
				parcours_classif,
				parcours_dtcrea,
				parcours_dtmaj,
				parcours_uscrea,
				parcours_usmaj,
				parcours_marqimp)
				VALUES (
				'".addslashes($parcours_c)."',
				'".$usermajcartokksig."',
				".$parcours_discp.",
				'MULTILINESTRING(".$tbvc[astext].")',
				'Largeur ".addslashes($row[largeur]).", etat:".addslashes($row[etat]).", Cours d\'eau ".addslashes($row[top_c_eau])."',
				".$srcg_id.",
				'".$tbvc[objectid]."',
				'".addslashes($row[nature])."',
				'".date('Y-m-d')."',
				'".date('Y-m-d')."',
				1,1,
				'".$_REQUEST[actionname]."_".$_REQUEST[marqimp]."'
				)";
				//echo $req_ins;
				$resins=$db->s_query($req_ins) or die("req ins $req_ins INVALIDE");
				
				$querup="update parcours set parcours_length=Length2D(parcours_geom), parcours_start=StartPoint(parcours_geom),parcours_time=ceil(Length2D(parcours_geom)/".($vitmoy*1000/60).") where parcours.oid=".pg_last_oid($resins).";";
				$resup=$db->s_query($querup) or die("req up $querup INVALIDE");
				
				echo "Parcours". $row[parcours]." ajouté en base <BR/>";
			}
			$parcours_c=$row[parcours];
			$tbvc[objectid]=$row[objectid];
			$tbvc[id_bdcarto]=$row[id_bdcarto];
			$tbvc[astext]=substr(substr($row[astext],0,strlen($row[astext])-1),16); // vire MULTILINESTRING( et )
		} else { // fin si changement de nom parcours
			$parcours_c=$row[parcours];
			$tbvc[objectid].=",".$row[objectid];
			$tbvc[id_bdcarto].=",".$row[id_bdcarto];
			$tbvc[astext].=",".substr(substr($row[astext],0,strlen($row[astext])-1),16);
		}
	} // fin boucle
} // fin si imp-cpie	


 
/* !!!!!!!!!!!!!!!!!!!!!!!!!!!
! IMPORT PDIPR CREUSE  CPIE  !
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! */

if ($_REQUEST[actionname]=="impcpie") {

/*champs Origine
//gid,"identifian","longueur","créateur","itinéraire","maj","nom","numéroiti","classifica","réf_ign","pdipr","cp","ad","vocation","handicapés","parcours","dénivelé_p","dénivelé_m","altitudede","altitudema","difficulté","duréea","duréear","propageacc","the_geom")


parcours_id serial NOT NULL,
    parcours_name character varying(255),
    parcours_user character varying(255),
    parcours_level integer,
    parcours_length integer,
    parcours_discp character varying,
    parcours_geom geometry,
    parcours_start geometry,
    parcours_time integer,
    parcours_ttop character varying,
    parcours_desc text,
    parcours_ouvert boolean DEFAULT true,
    parcours_fermet_details text,
    parcours_fermet_point geometry,
    parcours_guides character varying,
    parcours_equipt character varying DEFAULT 1,
    parcours_interet character varying DEFAULT 1,
    parcours_topo text,
    parcours_photo character varying,
    parcours_balisage integer DEFAULT 1,
    parcours_valid integer DEFAULT 0,
    parcours_source integer DEFAULT 0,
    parcours_dtcrea timestamp without time zone,
    parcours_dtmaj timestamp without time zone,
    parcours_uscrea character varying,
    parcours_usmaj character varying,
    parcours_environmt character varying DEFAULT 1,
*/

	$usermajcartocpie="manu-cpie";

	$parcours_discp="1"; // pedestre
	$vitmoy=RecupLib("disciplines","disc_id","disc_vitmoy",$parcours_discp);
	$srcg_id=1; // CPIE
	echo "vitmoy: $vitmoy";

	echo "MAJ des tracés CPIE<BR/>";
	
	$qu_sel="select * from zimptmp_iti_cpie";
	$rep=$db->s_query($qu_sel);
	while ($row=pg_fetch_assoc($rep)) {
		$req_ins="insert into parcours (
		parcours_name,
		parcours_user,
		parcours_discp,
		parcours_geom,
		parcours_desc,
		parcours_source,
		parcours_idsource,
		parcours_classif,
		parcours_dtcrea,
		parcours_dtmaj,
		parcours_uscrea,
		parcours_usmaj,
		parcours_marqimp)
		VALUES (
		'".addslashes($row[nom])."',
		'".$usermajcartocpie."',
		".$parcours_discp.",
		'".$row[the_geom]."',
		'identifiant SIG CPIE23:".$row[identifian].", classification:".$row[classifica].", cree par ".$row['cr?ateur']."',
		".$srcg_id.",
		'".$row[classifica]."',
		'".$row[identifian]."',
		'".date('Y-m-d')."',
		'".date('Y-m-d')."',
		1,1,
		'".$_REQUEST[actionname]."_".$_REQUEST[marqimp]."'
		)";
		$resins=$db->s_query($req_ins) or die("req ins $req_ins INVALIDE");
		
		$querup="update parcours set parcours_length=Length2D(parcours_geom), parcours_start=StartPoint(parcours_geom),parcours_time=ceil(Length2D(parcours_geom)/".($_SESSION['vitmoy']*1000/60).") where parcours.oid=".pg_last_oid($resins).";";
		$resup=$db->s_query($querup) or die("req up $querup INVALIDE");
		
		echo "Parcours". $row[identifian]." ajouté en base <BR/>";
	} // fin boucle
} // fin si imp-cpie	

/* !!!!!!!!!!!!!!!!!!!!!!!!!!!
! IMPORT CG 19 CYCLOTOURISME !
!!!!!!!!!!!!!!!!!!!!!!!!!!!!!! */

if ($_REQUEST[actionname]=="impctcg19") {

/*champs Origine 
//gid,"nom","the_geom")


parcours_id serial NOT NULL,
    parcours_name character varying(255),
    parcours_user character varying(255),
    parcours_level integer,
    parcours_length integer,
    parcours_discp character varying,
    parcours_geom geometry,
    parcours_start geometry,
    parcours_time integer,
    parcours_ttop character varying,
    parcours_desc text,
    parcours_ouvert boolean DEFAULT true,
    parcours_fermet_details text,
    parcours_fermet_point geometry,
    parcours_guides character varying,
    parcours_equipt character varying DEFAULT 1,
    parcours_interet character varying DEFAULT 1,
    parcours_topo text,
    parcours_photo character varying,
    parcours_balisage integer DEFAULT 1,
    parcours_valid integer DEFAULT 0,
    parcours_source integer DEFAULT 0,
    parcours_dtcrea timestamp without time zone,
    parcours_dtmaj timestamp without time zone,
    parcours_uscrea character varying,
    parcours_usmaj character varying,
    parcours_environmt character varying DEFAULT 1,
*/


$parcours_discp="5"; // cyclotourisme
$vitmoy=RecupLib("disciplines","disc_id","disc_vitmoy",$parcours_discp);
$srcg_id=3; // CG19, CycloT
$usermajcartoctcg19="smilgram";

echo "vitmoy: $vitmoy <br/>";

	echo "IMPORT DES TRACES CT CG19<BR/>";
	
	$qu_sel="select * from zimptmp_ctcg19";
	$rep=$db->s_query($qu_sel);
	while ($row=pg_fetch_assoc($rep)) {
		$req_ins="insert into parcours (
		parcours_name,
		parcours_user,
		parcours_discp,
		parcours_geom,
		parcours_desc,
		parcours_source,
		parcours_idsource,
		parcours_dtcrea,
		parcours_dtmaj,
		parcours_uscrea,
		parcours_usmaj,
		parcours_marqimp)
		VALUES (
		'test import mapinfo cg19".addslashes($row[nom])."',
		'".$usermajcartoctcg19."',
		".$parcours_discp.",
		'".$row[the_geom]."',
		'identifiant SIG CT 19 :".$row[gid]."',
		".$srcg_id.",
		'".$row[gid]."',
		'".date('Y-m-d')."',
		'".date('Y-m-d')."',
		1,1,
		'".$_REQUEST[actionname]."_".$_REQUEST[marqimp]."'
		)";
		$resins=$db->s_query($req_ins) or die("req ins $req_ins INVALIDE");
		
		$querup="update parcours set parcours_length=Length2D(parcours_geom), parcours_start=StartPoint(parcours_geom),parcours_time=ceil(Length2D(parcours_geom)/".($vitmoy*1000/60).") where parcours.oid=".pg_last_oid($resins).";";
		$resup=$db->s_query($querup) or die("req up $querup INVALIDE");
		
		echo "Parcours". $row[nom]." ajouté en base <BR/>";
	} // fin boucle
} // fin si imp-cpie	
unset($_REQUEST);
?>
