<?
$mapmargin = 11; // taille de la bordure clicable de navigation perpendiculaire
$blockspc=7; // espaces entre les blocks de droite
$types[1] = "Pédestre";
$types[2] = "Equestre";
$types[3] = "Cyclable";
$types[4] = "Kayak";
$typescolor[1]="faaa14"; // couleurs correspondant à chaque type, en hexa sur *6* caract !!
$typescolor[2]="8cdc8c"; 
$typescolor[3]="6cbee6"; 
$typescolor[4]="fa825a"; 
/* marche pô
$icontypes[1] = "maps/images/p_marche.png";
$icontypes[2] = "../maps/images/p_cheval.png";
$icontypes[3] = "/maps/images/p_vtt.png";
$icontypes[4] = "/maps/images/p_canoe.png"; */

$times[1] = "< 1/2h";
$times[2] = "< 1h";
$times[3] = "1 à 2 h";
$times[4] = "> 2h";
$levels[1] = "1";
$levels[2] = "2";
$levels[3] = "3";
$levels[4] = "4";
$levels[5] = "5";
$mapfile = "limousin.map";
$sf = 6000; // distance autour d'une ville lors d'un focus ville

// paramètres des tracés de couches postgis
$intparcwdth=3; // épaisseur interne des traits de tracés
$extparcwdth=7; // épaisseur externe des traits de tracés
$parclabelsize=10;
$parclabelfont="Verdana";
$rapechelpix=5714; // rapport d'échelle // ne fonctionne pas
$minscaledisplabels=100000; // echelle min a partir de laquelle on affiche les labels des parcours
?>
