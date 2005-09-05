<?php 
$title = "Détails du parcours";
$db = true;
include("setup.php");
?>

<?php 
$parc_name=RecupLib("parcours","parcours_id","parcours_name",$_REQUEST["parcours_id"]);
$smarty->assign('parc_name',$parc_name);

$nbpoints=$db->getone("select NumPoints(parcours_geom) from parcours where parcours_id=".$_REQUEST["parcours_id"]);
$parc_length=floor($db->getone("select Length2D(parcours_geom) from parcours where parcours_id=".$_REQUEST["parcours_id"]));

$smarty->assign('parc_length',$parc_length);

//$parc_geom=$db->getone("select asEWKT(parcours_geom) from parcours where parcours_id=".$_REQUEST["parcours_id"]);
//echo $parc_geom."\n";

// calcul du dénivellé positif
$nbpaltOk=0;
$cst_distm=50;
for ($i=1;$i<=$nbpoints;$i++) {
	$Cpoint=$db->queryone("select X(PointN(parcours_geom,$i)),Y(PointN(parcours_geom,$i)),Z(PointN(parcours_geom,$i)) from parcours where parcours_id=".$_REQUEST["parcours_id"]);
	
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

$smarty->display("pop_det_parc.tpl");

?>
</blockquote>
</body></html>
