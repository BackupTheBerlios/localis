<?php 
/* 
AU début ce fichier était affiché via une popup. Mais comm e cela merde avec IE, il est affiché dans le map en mode "unique"

$title = "Détails du parcours";
$db = true;
include("setup.php");
*/
?>

<?php 
$parc_name=RecupLib("parcours","parcours_id","parcours_name",$_SESSION['pid']);
$smarty->assign('parc_name',$parc_name);

$nbpoints=$db->getone("select NumPoints(parcours_geom) from parcours where parcours_id=".$_SESSION['pid']);
$parc_length=floor($db->getone("select Length2D(parcours_geom) from parcours where parcours_id=".$_SESSION['pid'])/100)/10;

$smarty->assign('parc_length',$parc_length);

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
$smarty->assign('deniv_ok',$deniv_ok);

if ($deniv_ok) {
	$smarty->assign('denivtot',floor($denivtot));
	$_SESSION['datas']=$datas; // pour imgpostgraph.php
} 
//

//$reqcust="select parcours_level,parcours_balisage,balis_ico,parcours_ttop,parcours_desc,parcours_guides,guid_url,parcours_equipt,parcours_interet,parcours_topo,parcours_photo,parcours_environmt from parcours,balisages,guides where parcours_id=".$_SESSION['pid']." and balis_id=parcours_balisage and guid_id = parcours_guides" ;

$reqcust="select parcours_level,parcours_balisage,parcours_ttop,parcours_desc,parcours_guides,parcours_equipt,parcours_interet,parcours_topo,parcours_photo,parcours_environmt from parcours where parcours_id=".$_SESSION['pid']." " ;
$req=db_query($reqcust);

$tbValChp=db_fetch_array($req);
//debug($tbValChp);

$ECT=InitPOReq($reqcust,"etoil");

$tb_infparc.='<TABLE class="table">';
$tb_infparc.='<thead><th>Attribut</th><th>Valeur</th></thead>';
foreach ($ECT as $PYAObj) {
  $PYAObj->TypEdit="C"; // en consultation seule en readonly ou eq spéciale
  $PYAObj->DirEcho=false;
  $NM_CHAMP=$PYAObj->NmChamp;
  
  //if ($modif!="") 
  $PYAObj->ValChp=$tbValChp[$NM_CHAMP];
  $debug="nm chp:".$NM_CHAMP."; val".$tbValChp[$NM_CHAMP];

  // ICI les traitements avant Mise à Jour
  if ($modif==2) { // en cas de COPIE on annule la valeur auto incrémentée
    if (stristr($PYAObj->FieldExtra,"auto_increment")) $PYAObj->ValChp="";
    }

  // traitement valeurs avant MAJ
  $PYAObj->InitAvMaj($$VarNomUserMAJ);

  if ($PYAObj->TypeAff!="HID" && $tbValChp[$NM_CHAMP]!="NULL" && $tbValChp[$NM_CHAMP]!="") {
      $tb_infparc.="<TR><TD>".$PYAObj->Libelle;

     $tb_infparc.="</TD>\n<TD>";
     $tb_infparc.=$PYAObj->EchoEdit(true);
     
     $tb_infparc.="</TD>\n</TR>"; //finit la ligne du tableau
   }
   // else $tb_infparc.=$PYAObj->EchoEditAll(true); // !!!!!!!!!!!!!!!! /

  } // fin while
$tb_infparc.="</table>";
$smarty->assign('tb_infparc',$tb_infparc);

//$smarty->display("pop_det_parc.tpl");
?>