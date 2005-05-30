<?
$anonym_disp_maps=false; // affichage carte aux anonymes (pour le proto, on n'affiche les cartes que si on est identifi�)
$coef_fd=1.5; // coefficient de d�placement lors du clic sur les fl�ches de direction
$mapmargin = 11; // taille de la bordure clicable de navigation perpendiculaire
$blockspc=7; // espaces entre les blocks de droite
$types[1] = "P&eacute;destre";
$types[2] = "Equestre";
$types[3] = "VTT";
$types[4] = "Kayak";
$types[5] = "Cyclotourisme";
$types[6] = "Attelage";

// utilisé pour les couches et les symboles mapserver
$name[1] = "marche";
$name[2] = "cheval";
$name[3] = "vtt";
$name[4] = "canoe";
$name[5] = "vtc";
$name[6] = "attel";

$typescolor[1]="fea034"; // couleurs correspondant à chaque type, en hexa sur *6* caract !!
$typescolor[2]="2f9535";
$typescolor[3]="f25254"; 
$typescolor[4]="9cc9e1"; 
$typescolor[5]="f79b9d"; 
$typescolor[6]="9ad47f";

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
$sf = 6000; // distance autour d'une ville lors d'un focus ville
$deptsregion="(19,23,87)";
$pcarpc=7; // pourcentage de marge autour d'un parcours lors d'un zoom
$refwidth=100; //largeur de la carte de reference
$refheight=100; //largeur de la carte de reference

// paramètres des tracés de couches postgis
// concernant les parcours
$intparcwdth=3; // épaisseur interne des traits de tracés
$minscaledispextparc=100000; // echelle min a partir de laquelle on affiche les contours en noir des traces de parcours
$extparcwdth=7; // épaisseur externe des traits de tracés
$parclabelsize=10;
$parclabelfont="Verdana";
$minscaledisplabels=100000; // echelle min a partir de laquelle on affiche les labels des parcours et des points LEI
$xd2pp=10; // dimension x picto parcours div par 2: sert pour les maparea d�finissant les zones cliquables sur les pictos des parcours
$yd2pp=10; // id y

// parametres couche LEI
$leilabelsize=8;
$leilabelfont="arial_italic";
$lei_f_url="http://193.108.140.161/etoil/cgi/interface.pyt?page=gab-produit.sk&boucle=p,prest2,p2,plink,crdp,crdp,hor,desext,listass2&critselect1=1900178&critselect2=1900067&produit=";
?>
