<?php 
/* 
AU d�ut ce fichier �ait affich�via une popup. Mais comm e cela merde avec IE, il est affich�dans le map en mode "unique"

$title = "D�ails du parcours";
$db = true;
include("setup.php");
*/
?>

<?php 

$reqcust ="select * from parcours where parcours_id=".$_SESSION['pid']." " ;
$req=db_query($reqcust);
$tbValChp=db_fetch_array($req);
// maintenant ces infos sont stock�s en base, plutot qu ede les recalculer �chaque fois ...
$smarty->assign('parc_name',$tbValChp['parcours_name']);
$smarty->assign('parc_length',round($tbValChp['parcours_length']/1000,1));
$smarty->assign('parc_time',($tbValChp['parcours_time']>0 ? $tbValChp['parcours_time'] : floor($tbValChp['parcours_length']/$_SESSION['vitmoy']/100)/10));
$smarty->assign('denivtot',$tbValChp['parcours_deniv']);

// on ne refait les req geomatiques qu'n �ition du parcours
if ($_REQUEST['editpc']) { // on ne refait des calculs et requete sur la base qu'en �ition 
	$nbpoints=$db->getone("select NumPoints(parcours_geom) from parcours where parcours_id=".$_SESSION['pid']);
	$parc_length=floor($db->getone("select Length2D(parcours_geom) from parcours where parcours_id=".$_SESSION['pid']));
	
	
	//$parc_geom=$db->getone("select asEWKT(parcours_geom) from parcours where parcours_id=".$_SESSION['pid']);
	//echo $parc_geom."\n";
	
	// calcul du d�ivell�positif
	$nbpaltOk=0;
	$cst_distm=50;
	for ($i=1;$i<=$nbpoints;$i++) {
		$Cpoint=$db->queryone("select X(PointN(parcours_geom,$i)),Y(PointN(parcours_geom,$i)),Z(PointN(parcours_geom,$i)) from parcours where parcours_id=".$_SESSION['pid']);
		
		// si le premier est bon, on le prend a chaque coup
		if ($i==1 && $Cpoint[z] > 0) $datas[0]=$Cpoint[z];
		if ($i>1) {
			$dist=$dist + sqrt(($Cpoint[x] - $xppc)*($Cpoint[x] - $xppc) + ($Cpoint[y] - $yppc)*($Cpoint[y] - $yppc));
			if ($Cpoint[z] > 0) {
				$nbptm++;
				$moyzc += $Cpoint[z];
				
			}
			//echo ($dist-$distc)." | ".$nbptm."<br/>";
			if (($dist-$distc) > $cst_distm) { // on calcule la moyenne de hauteur ts les $cst_distm m
				if ($nbptm>0) $datas[round($dist,-2)]= ($moyzc / $nbptm) ;
				$nbptm=0;
				$moyzc=0;
				$distc=$dist;
			}
		}
		$xppc=$Cpoint[x];
		$yppc=$Cpoint[y];
		// si le dernier est bon, on le prend a chaque coup
		if ($i==$nbpoints && $Cpoint[z] > 0) $datas[$dist]=$Cpoint[z];
	} // fin boucle sur les points de la line string
	
	$denivtot=0;
	$i=0;
	if (is_array($datas)) {	// on a des donn�s d'altitude
		$deniv_ok=true;
		foreach ($datas as $h) {
			$i++;
			if ($i!=1 && ($h> $zppc)) $denivtot += ($h - $zppc);
			$zppc=$h;
		}
	}
		
	$tb_infparc.='<table border="1"><thead><th colspan="2">';
	$tb_infparc.='Elements recalcul� par le SIG </th></thead><tr><td>';
	
	
	if ($deniv_ok) {
		$denivtot=floor($denivtot);
		$tb_infparc.= "Ci-dessous la courbe de denivele telle qu'elle vient d'etre calculee en temps reel par le SIG: <br/>";
//		$_SESSION['datas']=$datas; // pour imgpostgraph.php
//		$tb_infparc.='<IMG SRC="imgpostgraph.php">';
		$_SESSION['datas']=$datas; // pour imgpostgraph.php
		$incimgp=true; 
		$img_name=$_SESSION['pid']."_graph_deniv.jpg";
		$filetogen=$chem_abs_genimgtmp.$img_name;
		include ("imgpostgraph.php"); 
		$tb_infparc.='<IMG SRC="'.$chem_web_genimgtmp.$img_name.'">';
		$tb_infparc.=echochphid("parcours_deniv_fname",$img_name,false);
		$tb_infparc.='<br><input name="parcours_deniv_cgraph" type="checkbox" value="'.$filetogen.'" checked/> <b>enregistrer ce graphe</b> de denivelle pour ce parcours';
		

	} else {
		$tb_infparc.= " Aucune information de d�ivell�disponible pour ce parcours";
	}
	$tb_infparc.="</td><td>";
	$tb_infparc.="<br/><b>&#149; Longueur</b> du parcours \"recalculee\" par le SIG (en m) :<b> ".$parc_length."</b>";
	$tb_infparc.='<br><input name="parcours_length_cvalue" type="checkbox" value="'.$parc_length.'" '.($tbValChp['parcours_length']>0 ? "" : "checked").'/> <b>enregistrer cette valeur</b> de longueur pour ce parcours';
	$timec=floor($parc_length/100/$_SESSION['vitmoy'])/10;
	$tb_infparc.="<br/><br/><b>&#149; Temps</b> du parcours \"recalcul&eacute;\" par le SIG, avec une vitesse moyenne de ".$_SESSION['vitmoy']." km/h: <b> ".$timec." h </b>";
	$tb_infparc.='<br><input name="parcours_time_cvalue" type="checkbox" value="'.$timec.'" '.($tbValChp['parcours_time']>0 ? "" : "checked").'/> <b>enregistrer ce temps</b> pour ce parcours';
	$tb_infparc.="<br/><small><u>N.B. :</u>la vitesse moyenne d'une discipline est reparametrable, demandez a l'administrateur systeme</small>"; 
	
	if ($deniv_ok) {
		$tb_infparc.="<br/><br/><b>&#149; Denivele</b> du parcours \"recalculee\" par le SIG (en m) :<b> ".$denivtot."</b>";
		// genere une chcbox, pr�och� si valeur en bdd =0; non coch� sinon
		$tb_infparc.='<br><input name="parcours_deniv_cvalue" type="checkbox" value="'.$denivtot.'" '.($tbValChp['parcours_deniv']>0 ? "" : "checked").'/> <b>enregistrer cette valeur</b> de denivele pour ce parcours';
		
		}
	$tb_infparc.="<br/<br/><small>les valeurs recalcul�s par le SIG peuvent diff�er ce ces mesur�s sur le terrain. C'est pourquoi il est possible de les ressaisir manuellement ci-dessous</small>";
	
	$tb_infparc.='<br/<br/><input type="reset" value="ANNULER LES MODIFICATIONS" class="redbutton"> <br/><input type="submit" onclick="ChgMeth(); document.f.action=\'maj_table.php\'; document.f.submit()" class="redbutton" name="toto" value="!! ENREGISTRER LES MODIFICATIONS D\'ATTRIBUTS DE CE PARCOURS !!"/>&nbsp;';
	
	$tb_infparc.="</td><tr></table>";

	//
} // fin si on est en edition

$usercid=RecupLib("users","login","user_id",$_SESSION['me']);

$booluscreaconnect= ($tbValChp['parcours_uscrea']==$usercid || $_SESSION['admin']);

// bouton edition affich�
if ($booluscreaconnect  && !$_REQUEST['editpc']) {
	$tb_infparc.='<input id="edithid" type="hidden" name="editpc" value="">
	<input type="submit"  onclick="document.getElementById(\'edithid\').value=\'true\'; document.f.submit()" class="redbutton" name="toto" value="!! MODIFIER LES ATTRIBUTS DE CE PARCOURS !!"/>';

}
$tb_infparc.='<TABLE class="table">';
$tb_infparc.='<thead><th>Attribut</th><th>Valeur</th></thead>';



// Cr�tion et Initialisation des propri�� des objets PYAobj

$reqLChp="SELECT NM_CHAMP from $TBDname where NM_TABLE='parcours' AND NM_CHAMP!='$NmChDT' AND (TYPEAFF!='HID' OR (TT_PDTMAJ!='' AND TT_PDTMAJ!= NULL)) ORDER BY ORDAFF, LIBELLE";



$rq1=db_query($reqLChp) or die ("req 2 invalide");
//foreach ($ECT as $PYAObj) {
while ($CcChp=db_fetch_row($rq1)) { // boucles sur les champs
  $PYAObj=new PYAobj();
  $PYAObj->NmBase=$dbname;
  $PYAObj->NmTable="parcours";
  $NM_CHAMP=$CcChp[0];
  $PYAObj->NmChamp=$NM_CHAMP;
  if (!$_REQUEST['editpc']) $PYAObj->TypEdit="C"; // en consultation seule si on a pas appel�l'�ition
  $PYAObj->InitPO();
  if ($PYAObj->TypeAff=="POPL") $poplex=true; // s'il existe au moins une edition en popup li�
  $PYAObj->DirEcho=false;
  $PYAObj->ValChp=$tbValChp[$NM_CHAMP]; // si pas cr�tion (edit ou copy recup la val)
  
// en acces anonyme, donc on cache tous ceux-l�if (!$booluscreaconnect) {
     switch ($NM_CHAMP) {
  	case "parcours_id" :
	case "parcours_discp" :
	case "parcours_name" :
	case "parcours_user" :
	case "parcours_start" : 
	case "parcours_ouvert" :
	case "parcours_fermet_details" :
	case "parcours_fermet_point" :
	case "parcours_valid" :
	case "parcours_dtcrea" :
	case "parcours_uscrea" :
	case "parcours_usmaj" :
	
	if (!$booluscreaconnect) $PYAObj->TypeAff="HID";
		
	break;
    }


// mise en consult forc� de certains champs si pas admin  
  switch ($NM_CHAMP) {
  	case "parcours_discp":
	case "parcours_idsource":
	case "parcours_marqimp":
	case "parcours_user":
		if (!$_SESSION['admin']) $PYAObj->TypeAff="HID";
	break;
	
  }
  //if ($modif!="") 
  $PYAObj->ValChp=$tbValChp[$NM_CHAMP];
    
  // traitement valeurs avant MAJ
  $PYAObj->InitAvMaj($usercid);

  if ($PYAObj->TypeAff!="HID" && $tbValChp[$NM_CHAMP]!="NULL" && $tbValChp[$NM_CHAMP]!="" || $_REQUEST['editpc'] ) {
     $tb_infparc.='<TR  class="table"><TD class="colattribut">'.$PYAObj->Libelle;
     if ($booluscreaconnect) $tb_infparc.="<br/><small>".$PYAObj->Comment."</small>";
     $tb_infparc.="</TD>\n<TD>";
     switch ($NM_CHAMP) {
     	case "parcours_length":
     		if ($PYAObj->TypEdit=="C") {
     			$tb_infparc.=round($tbValChp[$NM_CHAMP]/1000,1)." km"; }
     		else 	{
     			$tb_infparc.=$PYAObj->EchoEdit(true);
     			$tb_infparc.="<br/><small>Si vous changez la valeur, saisissez-la en <b><u>metres</b></u>; elle s'affichera en km pour les internautes</small>";
     			}
     		break;
     	
     	case "parcours_guides":
		if ($PYAObj->TypEdit=="C") {
			$rqg="SELECT guid_nom,guid_editeur,guid_collection,guid_photocouv,guid_descript,guid_url,guid_ref,guid_isbn,guid_prix,guid_etat from guides where guid_id=".$tbValChp['parcours_guides'];
			$TbPYAOG=RTbVChPO($rqg,$dbname);
			foreach ($TbPYAOG as $PYAOG) {
				$tb_infparc.=str_replace(":|",": ",$PYAOG)."<br/>";
			}
		}  // fin si mode consultation
		else $tb_infparc.=$PYAObj->EchoEdit($PYAObj->TypEdit=="C" ? false : true);
		
    		break;
     	
     	case "parcours_balisage":
		if ($PYAObj->TypEdit=="C") {
			$rqg="SELECT balis_nom,balis_desc,balis_color,balis_ico,balis_icoscomp from balisages where balis_id=".$tbValChp['parcours_balisage'];
			$TbPYAOG=RTbVChPO($rqg,$dbname);
			foreach ($TbPYAOG as $PYAOG) {
				$tb_infparc.=str_replace(":|",": ",$PYAOG)."<br/>";
			}
		}  // fin si mode consultation
		else $tb_infparc.=$PYAObj->EchoEdit($PYAObj->TypEdit=="C" ? false : true);
		
    		break;
     	
     	case "parcours_gestionnaire":
		if ($PYAObj->TypEdit=="C") {
			$rqg="SELECT gest_nom,gest_resp,gest_desc,gest_adresse1,gest_adresse2,gest_commune,gest_tel,gest_tel2,gest_fax,gest_email,gest_web from gestionnaires where gest_id=".$tbValChp['parcours_gestionnaire'];
			$TbPYAOG=RTbVChPO($rqg,$dbname);
			foreach ($TbPYAOG as $PYAOG) {
				$tb_infparc.=str_replace(":|",": ",$PYAOG)."<br/>";
			}
		}  // fin si mode consultation
		else $tb_infparc.=$PYAObj->EchoEdit($PYAObj->TypEdit=="C" ? false : true);
		
    		break;
     	
     	default :
     	$tb_infparc.=$PYAObj->EchoEdit($PYAObj->TypEdit=="C" ? false : true);
     	break;
     
     }
     $tb_infparc.="</TD>\n</TR>"; //finit la ligne du tableau
   }
   elseif ($_REQUEST['editpc'])  $tb_infparc.=$PYAObj->NmChamp.":".$PYAObj->EchoEditAll(true)."|"; // !!!!!!!!!!!!!!!! /

  } // fin while ie boucle sur les champs
$tb_infparc.="</table>";

if ($_REQUEST['editpc']) { // on est en edition, on peut valider)
	if ($poplex) JSpopup(); // s'il existe au moins une edition en popup li� colle le code d'ouverture d'une popup
	// pour amact_table.php
	$tb_infparc.=echochphid("modif","1",false);
	$tb_infparc.=echochphid("keyf",$_SESSION['pid']."_",false); // cl�pour fichier
	$tb_infparc.=echochphid("key","parcours_id=".$_SESSION['pid'],false); // cl�pour modif
	$tb_infparc.=echochphid("adrr_majt",$_SERVER["PHP_SELF"],false);
	$tb_infparc.=echochphid("NM_TABLE","parcours",false);
	// bouton supprimer pour l'admin seult 
	if ($_SESSION['admin']) $tb_infparc.='<br/><span class="redbutton"><br/><input type="checkbox" name="delete" value="on">!!! Supprimer ce parcours !!!<br/></span><br/>';
	
	$tb_infparc.='<input type="reset" value="ANNULER LES MODIFICATIONS" class="redbutton"> &nbsp; &nbsp; <input type="submit" onclick="ChgMeth(); document.f.action=\'maj_table.php\'; document.f.submit()" class="redbutton" name="toto" value="!! ENREGISTRER LES MODIFICATIONS D\'ATTRIBUTS DE CE PARCOURS !!"/>&nbsp;';
}	
$smarty->assign('tb_infparc',$tb_infparc);

//$smarty->display("pop_det_parc.tpl");
?>