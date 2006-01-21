<?
$anonym_disp_maps=false; // affichage carte aux anonymes (pour le proto, on n'affiche les cartes que si on est identifi�
$coef_fd=1.5; // coefficient de d�lacement lors du clic sur les fl�hes de direction
$mapmargin = 11; // taille de la bordure clicable de navigation perpendiculaire
$blockspc=7; // espaces entre les blocks de droite

$bool_disp_zoomp=true; // affichage par zoom pr��inis

$tbzoomd[]=1113619; // carte h�l�ne
$tbzoomd[]=450000; // jyj
$tbzoomd[]=300000; // scan 1000
$tbzoomd[]=180000; // scan r�gional
//$tbzoomd[]=70000; // georr 100 K
$tbzoomd[]=50000; // scan 100
$tbzoomd[]=25000; // scan 100
//$tbzoomd[]=14000; //georr 20K
//$tbzoomd[]=4000; // georr 5K

$nblzoom=count($tbzoomd) - 1;
$sf = 6000; // distance autour d'une ville lors d'un focus ville
$zlfv=4; // type de zoom (indice ds tbdzoom) lors d'un focus ville

function recalczl($zoomc) {
global $tbzoomd;
$zoomc=round($zoomc,-3);
for ($i=count($tbzoomd) - 1;$i>=0;$i--) {
	if ($zoomc <= $tbzoomd[$i]) return ($i);
	}
return (0); // au cas o
}

function r_zoompref($zooml,$zoom_factor) {
global $nblzoom;
if ($zoom_factor==1) {
	$vret= $zooml;
} elseif ($zoom_factor > 1) {
	$zooml++;
	$vret =min($zooml, $nblzoom);
} elseif ($zoom_factor<0) {
	$zooml --;
 	$vret=max($zooml, 0);
}
return($vret);
}

$zoom2x=2; 

$bool_disp_lay_LEI=true; // affichage de la couche LEI
$chem_abs_genimgtmp=PWWW."temp/";
$chem_web_genimgtmp="temp/";
// trucs pour utilisation PYA
$TBDname="DESC_TABLES";
$NmChDT="TABLE0COMM";

$tbidiscp=$db->query("select disc_id, disc_nom, disc_name, disc_color,disc_vitmoy from disciplines where disc_act=true order by disc_id",true);
//debug("tbidiscp");

foreach ($tbidiscp as $discp) {
	$discps[$discp['disc_id']]=$discp['disc_nom'];
	$name[$discp['disc_id']]=$discp['disc_name'];
	$discpcolor[$discp['disc_id']]=$discp['disc_color'];
	if ($_SESSION['discp_c']==$discp['disc_id']) {
		$_SESSION['vitmoy']=$discp['disc_vitmoy'];
	}
}
/*
$discps[1] = "P&eacute;destre";
$discps[2] = "Equestre";
$discps[3] = "VTT";
$discps[4] = "Kayak";
$discps[5] = "Cyclotourisme";
$discps[6] = "Attelage";

// utilisé pour les couches et les symboles mapserver
$name[1] = "marche";
$name[2] = "cheval";
$name[3] = "vtt";
$name[4] = "canoe";
$name[5] = "vtc";
$name[6] = "attel";

$discpcolor[1]="fea034"; // couleurs correspondant à chaque type, en hexa sur *6* caract !!
$discpcolor[2]="2f9535";
$discpcolor[3]="f25254"; 
$discpcolor[4]="9cc9e1"; 
$discpcolor[5]="f79b9d"; 
$discpcolor[6]="9ad47f";
*/
$selectedcolor="ff0000";

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

$deptsregion="(19,23,87)";
$pcarpc=7; // pourcentage de marge autour d'un parcours lors d'un zoom
$refwidth=100; //largeur de la carte de reference
$refheight=100; //largeur de la carte de reference

// paramètres des tracés de couches postgis
// concernant les parcours
$intparcwdth=3; // épaisseur interne des traits de tracés
$minscaledispzoomp=600000; // echelele au dessus de laquelel l'outil zoom + est s�ectionn�par d�aut
$minscaledispscan100legend=100000; // echelle min a partir de laquelle on affiche la l�ende de carte scan100
$minscaledispextparc=100000; // echelle min a partir de laquelle on affiche les contours en noir des traces de parcours
$minscaledisplabels=100000; // echelle min a partir de laquelle on affiche les labels des parcours 
$minscaledispictos=250000; // echelle min a partir de laquelle on affiche les pictos des parcours 

$extparcwdth=7; // épaisseur externe des traits de tracés
$parclabelsize=10;
$parclabelfont="Verdana";
$xd2pp=10; // dimension x picto parcours div par 2: sert pour les maparea d�inissant les zones cliquables sur les pictos des parcours
$yd2pp=10; // id y

// parametres couche LEI
$minscaledisp_leilabs=50000;
$leilabelsize=8;
$leilabelfont="arial_italic";
$lei_f_url="http://lei.crt-limousin.fr/etoil/cgi/interface.pyt?page=gab-produit.sk&boucle=p,prest2,p2,plink,crdp,crdp,hor,desext,listass2&critselect1=1900178&critselect2=1900067&produit=";
//$lei_f_url="interface.htm?idbid=";
?>
