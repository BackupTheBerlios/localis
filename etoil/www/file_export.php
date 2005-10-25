<? 
$debug=true;
$disp=false;
$title = "Export";
$db = true;
include("setup.php");

$head_pcx5='

H  SOFTWARE NAME & VERSION
I  PCX5 2.09

H  R DATUM                IDX DA             DF             DX             DY             DZ
M  G WGS 84               121 +0.000000e+000 +0.000000e+000 +0.000000e+000 +0.000000e+000 +0.000000e+000

H  COORDINATE SYSTEM
U  LAT LON DEG

H  LATITUDE    LONGITUDE    DATE      TIME     ALT   ;track

';

$parc_name=RecupLib("parcours","parcours_id","parcours_name",$_REQUEST["parcours_id"]);

// entetes http pour t�l�chargement
if (!$disp) {
header('Content-disposition: filename='.$parc_name.'.trk');
header('Content-type: application/octetstream');
//header('Content-type: text/plain');
//header('Content-type: application/ms-excel');
header('Pragma: no-cache');
header('Expires: 0');
}

$tab="\t"; //tab en ascii

//echo "On va exporter le parcours ".$_REQUEST["parcours_id"].$parc_name."\n\n";
echo $head_pcx5;
global $db; 
$nbpoints=$db->getone("select NumPoints(parcours_geom) from parcours where parcours_id=".$_REQUEST["parcours_id"]);
//echo "il y a $nbpoints points \n";

//$parc_geom=$db->getone("select asEWKT(parcours_geom) from parcours where parcours_id=".$_REQUEST["parcours_id"]);
//echo $parc_geom."\n";

//$nbpoints=5;
$vitmoy=2; // vitesse moyenne en m/s

for ($i=1;$i<=$nbpoints;$i++) {
	$Cpoint=$db->queryone("select X(PointN(parcours_geom,$i)),Y(PointN(parcours_geom,$i)),Z(PointN(parcours_geom,$i)) from parcours where parcours_id=".$_REQUEST["parcours_id"]);
	if ($i>1) {
		$dist=sqrt(($Cpoint[x] - $xppc)*($Cpoint[x] - $xppc) + ($Cpoint[y] - $yppc)*($Cpoint[y] - $yppc));
		$tps=$tps + $dist/$vitmoy;
	} else $tps=time(); // 1er coup on prend l'heure courante
	$xppc=$Cpoint[x];
	$yppc=$Cpoint[y];
	
//	print_r($Cpoint);
	//debug contr�le
	//echo $i." ".$Cpoint[x]." ".$Cpoint[y]." ".$Cpoint[z]." "."\n";
	$cmd="cs2cs +init=lambfr:27585 +to +proj=latlong +datum=WGS84 -f %2.7f <<EOF\n".$Cpoint[x]." ".$Cpoint[y]."\nEOF\n";
	$out=shell_exec($cmd);
	//echo "cmd out# ".$out." ---- ";
	// renvoie X (tab) y (espace) offset z
	$out=str_replace("\n","",$out); // remplace LF par rien
	$out=str_replace("\r","",$out); // remplace CR par rien
	$out=str_replace(chr(9)," ",$out); // remplace tab par esp
	//echo "cmd out2#".$out."---- ";
	$tb=explode(" ",$out);
	//print_r($tb);
	//$tb[0]: longitude (E/O): Est>0, W<0
	//$tb[1]: latitude (N/S) N>0, S<0
	$lat=($tb[1]>0 ? "N" : "S").raj2z(abs($tb[1]));
	$long=($tb[0]>0 ? "E" : "W").raj3z(abs($tb[0]));
	
	//$debugL=" ".$Cpoint[x]."|".$Cpoint[y]."|".$dist;
	echo "T  ".compdesp($lat,12).compdesp($long,13).compdesp(date("d-M-y H:i:s",$tps),19).($Cpoint[z] >0 ? round($tb[2] + $Cpoint[z]) : "-9999").$debugL."\n";
}

function compdesp($strtc,$nbe) {
	return($strtc.str_repeat(" ",$nbe-strlen($strtc)));
}

function raj2z($nb) {
if ($nb<10) $nb="0".$nb;
return($nb);
}

function raj3z($nb) {
if ($nb<10){ $nb="00".$nb;}
elseif($nb<100) {$nb="00".$nb;}
return($nb);
}

?>
