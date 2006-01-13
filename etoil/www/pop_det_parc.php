<?php 
/* 
AU début ce fichier était affiché via une popup. Mais comm e cela merde avec IE, il est affiché dans le map en mode "unique"

$title = "Détails du parcours";
$db = true;
include("setup.php");
*/
?>

<?php 

$reqcust ="select * from parcours where parcours_id=".$_SESSION['pid']." " ;
$req=db_query($reqcust);
$tbValChp=db_fetch_array($req);
// maintenant ces infos sont stockées en base, plutot qu ede les recalculer à chaque fois ...
$smarty->assign('parc_name',$tbValChp['parcours_name']);
$smarty->assign('parc_length',$tbValChp['parcours_length']);
$smarty->assign('parc_time',($tbValChp['parcours_time']>0 ? $tbValChp['parcours_time'] : floor($tbValChp['parcours_length']/$_SESSION['vitmoy']/100)/10));
$smarty->assign('denivtot',$tbValChp['parcours_deniv']);

// on ne refait les req geomatiques qu'n édition du parcours
if ($_REQUEST['editpc']) { // on ne refait des calculs et requete sur la base qu'en édition 
	$nbpoints=$db->getone("select NumPoints(parcours_geom) from parcours where parcours_id=".$_SESSION['pid']);
	$parc_length=floor($db->getone("select Length2D(parcours_geom) from parcours where parcours_id=".$_SESSION['pid']));
	
	
	//$parc_geom=$db->getone("select asEWKT(parcours_geom) from parcours where parcours_id=".$_SESSION['pid']);
	//echo $parc_geom."\n";
	
	// calcul du dénivellé positif
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
	if (is_array($datas)) {	// on a des données d'altitude
		$deniv_ok=true;
		foreach ($datas as $h) {
			$i++;
			if ($i!=1 && ($h> $zppc)) $denivtot += ($h - $zppc);
			$zppc=$h;
		}
	}
		
	$tb_infparc.='<table border="1"><thead><th colspan="2">';
	$tb_infparc.='Elements recalculés par le SIG </th></thead><tr><td>';
	
	
	if ($deniv_ok) {
		$denivtot=floor($denivtot);
		$tb_infparc.= "Ci-dessous la courbe de dénivellé telle qu'elle vient d'être calculée en temps réel par le SIG: <br/>";
//		$_SESSION['datas']=$datas; // pour imgpostgraph.php
//		$tb_infparc.='<IMG SRC="imgpostgraph.php">';
		$_SESSION['datas']=$datas; // pour imgpostgraph.php
		$incimgp=true; 
		$img_name=$_SESSION['pid']."_graph_deniv.jpg";
		$filetogen=$chem_abs_genimgtmp.$img_name;
		include ("imgpostgraph.php"); 
		$tb_infparc.='<IMG SRC="'.$chem_web_genimgtmp.$img_name.'">';
		$tb_infparc.=echochphid("parcours_deniv_fname",$img_name,false);
		$tb_infparc.='<br><input name="parcours_deniv_cgraph" type="checkbox" value="'.$filetogen.'" checked/> <b>enregistrer ce graphe</b> de dénivellé pour ce parcours';
		

	} else {
		$tb_infparc.= " Aucune information de dénivellé disponible pour ce parcours";
	}
	$tb_infparc.="</td><td>";
	$tb_infparc.="<br/><b>&#149; Longueur</b> du parcours \"recalculée\" par le SIG (en m) :<b> ".$parc_length."</b>";
	$tb_infparc.='<br><input name="parcours_length_cvalue" type="checkbox" value="'.$parc_length.'" '.($tbValChp['parcours_length']>0 ? "" : "checked").'/> <b>enregistrer cette valeur</b> de longueur pour ce parcours';
	$timec=floor($parc_length/100/$_SESSION['vitmoy'])/10;
	$tb_infparc.="<br/><br/><b>&#149; Temps</b> du parcours \"recalculé\" par le SIG, avec une vitesse moyenne de ".$_SESSION['vitmoy']." km/h: <b> ".$timec." h </b>";
	$tb_infparc.='<br><input name="parcours_time_cvalue" type="checkbox" value="'.$timec.'" '.($tbValChp['parcours_time']>0 ? "" : "checked").'/> <b>enregistrer ce temps</b> pour ce parcours';
	$tb_infparc.="<br/><small><u>N.B. :</u>la vitesse moyenne d'une discipline est reparamétrable, demandez à l'admistrateur système</small>"; 
	
	if ($deniv_ok) {
		$tb_infparc.="<br/><br/><b>&#149; Dénivellé</b> du parcours \"recalculée\" par le SIG (en m) :<b> ".$denivtot."</b>";
		// genere une chcbox, précochée si valeur en bdd =0; non cochée sinon
		$tb_infparc.='<br><input name="parcours_deniv_cvalue" type="checkbox" value="'.$denivtot.'" '.($tbValChp['parcours_deniv']>0 ? "" : "checked").'/> <b>enregistrer cette valeur</b> de dénivellé pour ce parcours';
		
		}
	$tb_infparc.="<br/<br/><small>les valeurs recalculées par le SIG peuvent différer ce ces mesurées sur le terrain. C'est pourquoi il est possible de les ressaisir manuellement ci-dessous</small>";
	
	$tb_infparc.='<br/<br/><input type="reset" value="ANNULER LES MODIFICATIONS" class="redbutton"> <br/><input type="submit" onclick="ChgMeth(); document.f.action=\'maj_table.php\'; document.f.submit()" class="redbutton" name="toto" value="!! ENREGISTRER LES MODIFICATIONS D\'ATTRIBUTS DE CE PARCOURS !!"/>&nbsp;';
	
	$tb_infparc.="</td><tr></table>";

	//
} // fin si on est en édition 

$usercid=RecupLib("users","login","user_id",$_SESSION['me']);

$booluscreaconnect= ($tbValChp['parcours_uscrea']==$usercid || $_SESSION['admin']);

// bouton edition affiché
if ($booluscreaconnect  && !$_REQUEST['editpc']) {
	$tb_infparc.='<input id="edithid" type="hidden" name="editpc" value="">
	<input type="submit"  onclick="document.getElementById(\'edithid\').value=\'true\'; document.f.submit()" class="redbutton" name="toto" value="!! MODIFIER LES ATTRIBUTS DE CE PARCOURS !!"/>';
}

$tb_infparc.='<TABLE class="table">';
$tb_infparc.='<thead><th>Attribut</th><th>Valeur</th></thead>';



// Création et Initialisation des propriétés des objets PYAobj

$reqLChp="SELECT NM_CHAMP from $TBDname where NM_TABLE='parcours' AND NM_CHAMP!='$NmChDT' AND (TYPEAFF!='HID' OR (TT_PDTMAJ!='' AND TT_PDTMAJ!= NULL)) ORDER BY ORDAFF, LIBELLE";



$rq1=db_query($reqLChp) or die ("req 2 invalide");
//foreach ($ECT as $PYAObj) {
while ($CcChp=db_fetch_row($rq1)) { // boucles sur les champs
  $PYAObj=new PYAobj();
  $PYAObj->NmBase=$dbname;
  $PYAObj->NmTable="parcours";
  $NM_CHAMP=$CcChp[0];
  $PYAObj->NmChamp=$NM_CHAMP;
  if (!$_REQUEST['editpc']) $PYAObj->TypEdit="C"; // en consultation seule si on a pas appelé l'édition
  $PYAObj->InitPO();
  if ($PYAObj->TypeAff=="POPL") $poplex=true; // s'il existe au moins une edition en popup liée
  $PYAObj->DirEcho=false;
  $PYAObj->ValChp=$tbValChp[$NM_CHAMP]; // si pas création (edit ou copy recup la val)
  
// en acces anonyme, donc on cache tous ceux-là
if (!$booluscreaconnect) {
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
	
	$PYAObj->TypeAff="HID";
	break;
    }
}

// mise en consult forcée de certains champs si pas admin  
  switch ($NM_CHAMP) {
  	case "parcours_discp":
	case "parcours_idsource":
	case "parcours_marqimp":
	case "parcours_user":
		if (!$_SESSION['admin']) $PYAObj->TypEdit="C";
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
     $tb_infparc.=$PYAObj->EchoEdit($PYAObj->TypEdit=="C" ? false : true);
     $tb_infparc.="</TD>\n</TR>"; //finit la ligne du tableau
   }
   elseif ($_REQUEST['editpc'])  $tb_infparc.=$PYAObj->NmChamp.":".$PYAObj->EchoEditAll(true)."|"; // !!!!!!!!!!!!!!!! /

  } // fin while
$tb_infparc.="</table>";

if ($_REQUEST['editpc']) { // on est en edition, on peut valider)
	if ($poplex) JSpopup(); // s'il existe au moins une edition en popup liée colle le code d'ouverture d'une popup
	// pour amact_table.php
	$tb_infparc.=echochphid("modif","1",false);
	$tb_infparc.=echochphid("keyf",$_SESSION['pid']."_",false); // clé pour fichier
	$tb_infparc.=echochphid("key","parcours_id=".$_SESSION['pid'],false); // clé pour modif
	$tb_infparc.=echochphid("adrr_majt",$_SERVER["PHP_SELF"],false);
	$tb_infparc.=echochphid("NM_TABLE","parcours",false);
	// bouton supprimer pour l'admin seult 
	if ($_SESSION['admin']) $tb_infparc.='<br/><span class="redbutton"><br/><input type="checkbox" name="delete" value="on">!!! Supprimer ce parcours !!!<br/></span><br/>';
	
	$tb_infparc.='<input type="reset" value="ANNULER LES MODIFICATIONS" class="redbutton"> &nbsp; &nbsp; <input type="submit" onclick="ChgMeth(); document.f.action=\'maj_table.php\'; document.f.submit()" class="redbutton" name="toto" value="!! ENREGISTRER LES MODIFICATION SD\'ATTRIBUTS DE CE PARCOURS !!"/>&nbsp;';
}	
$smarty->assign('tb_infparc',$tb_infparc);

//$smarty->display("pop_det_parc.tpl");
?>