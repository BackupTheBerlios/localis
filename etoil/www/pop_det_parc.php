<?php 
$title = "Détails du parcours";
$db = true;
include("setup.php");
?>
<html>
<head><TITLE><?=$title?></TITLE>
<link rel="stylesheet" type="text/css" href="etoil.css">
</head>
<blockquote>
<?php 
$parc_name=RecupLib("parcours","parcours_id","parcours_name",$_REQUEST["parcours_id"]);
echo "<H3>Parcours : ".$parc_name."</H3>";
$nbpoints=$db->getone("select NumPoints(parcours_geom) from parcours where parcours_id=".$_REQUEST["parcours_id"]);
$parc_length=floor($db->getone("select Length2D(parcours_geom) from parcours where parcours_id=".$_REQUEST["parcours_id"]));

//$parc_geom=$db->getone("select asEWKT(parcours_geom) from parcours where parcours_id=".$_REQUEST["parcours_id"]);
//echo $parc_geom."\n";

echo "Ce parcours a une longueur de $parc_length m<br/><br/>";

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
	foreach ($datas as $h) {
		$i++;
		if ($i!=1 && ($h> $zppc)) $denivtot += ($h - $zppc);
		$zppc=$h;
	}
}

if ($denivtot>0) {
	echo "Ce parcours a un dénivellé positif total de ".floor($denivtot)." m<br/><br/>";
	$_SESSION['datas']=$datas;
	?>
	<img src="imgpostgraph.php?parcours_id=<?=$_REQUEST["parcours_id"]?>" align="middle">
	<?
} else {
echo "Les informations de dénivellé ne sont pas disponibles pour ce parcours<br/><br/>";
}
echo '<br/><br/><a href="#" class="button" onclick="window.close();">&nbsp;fermer&nbsp;</a>';
?>
</blockquote>
</body></html>
