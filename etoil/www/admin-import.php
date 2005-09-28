<?php
$title = "Gestion des utilisateurs";
$db = true;
$mod = false;
$feedback = $focus = array();
include("setup.php");

$usermajcartocpie="manu-cpie";
$marqimp="test_30092005";
echo '<h2>Bienvenue sur la page d\'importation directe des tracés</h2>
 <form method="post" action="admin-import.php">
 
<u>Actions disponibles:</u><br/>
<input type="radio" name="actionname" value="none" selected>Aucune<BR/>
<hr/>
<br>Opérations à réaliser pour un import du cpie :<br>
- Supprimer la table temporaire iti_cpie
- exécuter la commande 
<pre>/usr/local/pgsql/bin/shp2pgsql itinéraire_polyline.shp iti_cpie > /tmp/iti_cpie.sql</pre>
<input type="radio" name="actionname" value="impcpie">Import CPIE<BR/>

<hr/>
<input type="radio" name="actionname" value="majptdepcpie">MAJ Coordonnees point de départ cpie<BR/>
<hr/>
<br>Opérations à réaliser pour un import du cpie :<br>
- Supprimer la table temporaire iti_cpie
- exécuter la commande 
<pre>/usr/local/pgsql/bin/shp2pgsql itinéraire_polyline.shp iti_cpie > /tmp/iti_cpie.sql</pre>
<input type="radio" name="actionname" value="impcpie">Import CPIE<BR/>
<input type="submit">
</form>
'; 

if ($_REQUEST[actionname]=="impparckayak") {

/*champs Origines
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


$parcours_discp="4"; // kayak
$vitmoy=RecupLib("disciplines","disc_id","disc_vitmoy",$parcours_discp);
$srcg_id=2; // SIGR_CK
echo "vitmoy: $vitmoy";

	echo "MAJ des tracés CPIE<BR/>";
	
	$qu_sel="select * from iti_cpie";
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
		'".$marqimp."'
		)";
		$resins=$db->s_query($req_ins) or die("req ins $req_ins INVALIDE");
		
		$querup="update parcours set parcours_length=Length2D(parcours_geom), parcours_start=StartPoint(parcours_geom),parcours_time=ceil(Length2D(parcours_geom)/".($_SESSION['vitmoy']*1000/60).") where parcours.oid=".pg_last_oid($resins).";";
		$resup=$db->s_query($querup) or die("req up $querup INVALIDE");
		
		echo "Parcours". $row[identifian]." ajouté en base <BR/>";
	} // fin boucle
} // fin si imp-cpie	


 
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


$parcours_discp="1"; // pedestre
$vitmoy=RecupLib("disciplines","disc_id","disc_vitmoy",$parcours_discp);
$srcg_id=1; // CPIE
echo "vitmoy: $vitmoy";

	echo "MAJ des tracés CPIE<BR/>";
	
	$qu_sel="select * from iti_cpie";
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
		'".$marqimp."'
		)";
		$resins=$db->s_query($req_ins) or die("req ins $req_ins INVALIDE");
		
		$querup="update parcours set parcours_length=Length2D(parcours_geom), parcours_start=StartPoint(parcours_geom),parcours_time=ceil(Length2D(parcours_geom)/".($_SESSION['vitmoy']*1000/60).") where parcours.oid=".pg_last_oid($resins).";";
		$resup=$db->s_query($querup) or die("req up $querup INVALIDE");
		
		echo "Parcours". $row[identifian]." ajouté en base <BR/>";
	} // fin boucle
} // fin si imp-cpie	

if ($_REQUEST[actionname]=="majptdepcpie") {
	echo "on MAJ les points de dep et les tps de parcours <br/>";
	$querup="update parcours set parcours_length=Length2D(parcours_geom), parcours_start=StartPoint(parcours_geom),parcours_time=ceil(Length2D(parcours_geom)/".($vitmoy*1000/60).") where parcours_source=1;";
	$resup=$db->s_query($querup) or die("req up $querup INVALIDE");
	
}

?>
