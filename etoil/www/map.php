<?php 
$title = "Cartographie";
$db = true;
include("setup.php");
checkfontlist(PROOT."/maps");
include_once(PROOT."/libs/conf.php");

// sur le proto, on n'affiche la carte que si on est loggé avec un profil >=1 et que le code profil
$bool_map_disp=(!empty($_SESSION['me']) && $_SESSION['profile']>=1 ) || $anonym_disp_maps;
$smarty->assign('bool_map_disp',$bool_map_disp);

if (isset($_REQUEST['x'])) {
	$click_x = $_REQUEST['x'];
	$click_y = $_REQUEST['y'];
} else {
	$click_x = $click_y = false;
}

if (!isset($_REQUEST['action']))  $_REQUEST['action'] = "travel";
$zoom_factor=1; // défaut

if (isset($_REQUEST['purge']) and $_REQUEST['purge'] == 'all') {
	$_SESSION['track'] = array();
}

if (isset($_REQUEST['filtre'])) {
	$filtre = $_REQUEST['filtre'];
	$_SESSION['filtre'] = array();
	foreach ($filtre as $f=>$v) {
		$_SESSION["filtre"][$f] = $v;
	}
} elseif (isset($_SESSION['filtre'])) {
	$filtre = $_SESSION['filtre'];
}

if (isset($filtre)) {
	$smarty->assign('filtre',$filtre);
	foreach ($filtre as $f=>$v) {
		if (!empty($v)) $wh[] = "parcours_$f=$v";
	}
}

// ========================================================================
// special hack: si paramètre spécial spcsc25=tux129 passé en get (par l'url)
// utilise un fichier map specifique limousinhck.map)
$mapfile = PROOT. "/maps/$mapfile";

if (!empty($_REQUEST['spcsc25'])) {
	if ($_REQUEST['spcsc25']=="tux129") {
	$_SESSION['spcsc25']="tux129";
	}
	else unset($_SESSION['spcsc25']);
}	
$mapfile=(!empty($_SESSION['spcsc25']) ? PROOT. "/maps/limousinhck.map" : $mapfile);

$e_map = ms_newMapObj($mapfile);
// ces paramètres sont récupérés dans le mapfile static
$extminx = $extminxmf = $e_map->extent->minx;
$extminy = $extminymf = $e_map->extent->miny;
$extmaxx = $extmaxxmf = $e_map->extent->maxx;
$extmaxy = $extmaxymf = $e_map->extent->maxy;

// fonction qui désactive dans le mapfile toutes les couches qui
// ne font pas partie du groupe "fond"
// Pourquoi ?????
$lay = array("fond");
$layers = $e_map->getAllGroupNames();
foreach ($layers as $l) {
	$maplayer[] = $l;
	$tl = $e_map->getLayersIndexByGroup($l);
	if ((is_array($tl)) and (!in_array($l,$lay))) {
		foreach ($tl as $t) {
			$e_layer = $e_map->getLayer($t);
			echo "tl=$tl -> t=$t <br/>";
			$e_layer->set("status",MS_OFF);
		}
	}			
}

$e_limit = ms_newRectObj();
$e_limit->setextent($extminx,$extminy,$extmaxx,$extmaxy);

if (!empty($_REQUEST['extent'])) {
	list($extminx,$extminy,$extmaxx,$extmaxy) = split(' ',trim($_REQUEST['extent']));
}
$ext = array($extminx,$extminy,$extmaxx,$extmaxy);

$e_extent = ms_newRectObj();
$e_extent->setextent($ext[0],$ext[1],$ext[2],$ext[3]);

// changement de taille d'image-carte en pixels
if (!isset($_REQUEST['size'])) {
	$sizex = $e_map->width;
	$sizey = $e_map->height;
} else {
	list($sizex,$sizey) = split('x',$_REQUEST['size']);
}
$sizecheck["{$sizex}x{$sizey}"] = " selected=\"selected\"";
$e_map->set('width',$sizex);
$e_map->set('height',$sizey);

$e_click = ms_newPointObj();
$e_click->setXY(floor($sizex/2),floor($sizey/2),0); // par défaut, au centre

// recherche des villes correspondant aux critères
if (!empty($_REQUEST['ville'])) {
	$cities = $db->get_cities($_REQUEST['ville'],$deptsregion); // filtre rajouté pour les depts de la région
	if (!$cities or count($cities) == 0) {
		$feedback[] = array('num'=>-1,'msg'=>sprintf(tra('Désolé, aucun nom de ville en Limousin ne commence par %s.'),$_REQUEST['ville']));
	} elseif (count($cities) == 1) {
		$_REQUEST = array();
		$_REQUEST['focusville'] = $cities[0]['nom'];
		$_REQUEST['idfocusville'] = $cities[0]['id'];

	} else {
		$smarty->assign('cities',$cities);
	}
}
$action_OK=false; // par défaut, les actions (zoom, travel) qui a le focus n'est PAS appliquée
// il peut y avoir plein d'autres actions (recherche, resize, etc ..)

if (isset($_REQUEST['focusville'])) {
	$city_info = $db->get_city_info($_REQUEST['idfocusville']);
	if (!$city_info) {
		$feedback[] = array('num'=>-1,'msg'=>sprintf(tra('Désolé, aucun nom de ville en Limousin ne correspond à %s.'),$_REQUEST['focusville']));
	} else {
		$smarty->assign('city_info',$city_info);
		preg_match("/POINT\(([\.0-9]*) ([\.0-9]*)\)/",$city_info[0]['xy'],$m);
		$e_extent->setextent(floor($m[1]-$sf),floor($m[2]-$sf),floor($m[1]+$sf),floor($m[2]+$sf));
	}
} elseif (isset($_REQUEST['pid'])) {
	$parcours_info = $db->get_parcours_info($_REQUEST['pid']);
	preg_match("/POLYGON\(\(([\.0-9]*) ([\.0-9]*),[\.0-9]* ([\.0-9]*),([\.0-9]*) [\.0-9]*,[\.0-9]* [\.0-9]*,[\.0-9]* [\.0-9]*\)\)/",$parcours_info['ext'],$m);
	$d = (($m[4] - $m[1]) / $pcarpc); //$pcarpc=% autour du parcours
	$b = (($m[3] - $m[2]) / $pcarpc);
	$e_extent->setextent($m[1] - $d,$m[2] - $d,$m[4] + $b,$m[3] + $d);
} elseif (isset($_REQUEST['action']) && $_REQUEST['action'] == "zoomout") { // si zoom out, on zoome out sans attendre le click sur la carte, on fait comme si on avait cliqué au centre
	$click_x=floor($sizex/2);
	$click_y=floor($sizey/2);
	$zoom_factor=-2;
} 

if ($click_x and $click_y) { // click "normal" dans la carte 
	$map_click['x'] = floor($extminx + pix2geo($click_x,$extminx,$extmaxx,$sizex));
	$map_click['y'] = floor($extmaxy - pix2geo($click_y,$extminy,$extmaxy,$sizey));
	$e_click->setXY($click_x,$click_y,0);

} elseif (!empty($_REQUEST['dir'])) { // clic sur les fleches de dir autour
	list($fx,$fy) = $_REQUEST['dir'];
	$ffx['l'] = $ffx['t'] = -1;
	$ffx['c'] = 0;
	$ffx['r'] = $ffx['b'] = 1;
	$e_click->setXY(floor(($sizex/2)+($ffx[$fx]*$sizex/2)),floor(($sizey/2)+($ffx[$fy]*$sizey/2)),0);
}

$focus = array();
if (isset($_REQUEST['action'])) {
	if ($_REQUEST['action'] == "zoomin") {
		if (isset($map_click)) $zoom_factor=2;
		$focus['zoomin'] = "focus";
	} elseif ($_REQUEST['action'] == "zoomout") {
		if (isset($map_click)) $zoom_factor=-2;
		$focus['zoomout'] = "focus";
	} elseif ($_REQUEST['action'] == "travel") {
		$focus['travel'] = "focus";
	} elseif ($_REQUEST['action'] == "edit" and isset($_SESSION['admin']) and $_SESSION['admin']) {
		$focus['edit'] = "focus";
		if (isset($map_click)) $_SESSION['track'][] = $map_click['x']." ".$map_click['y'];
	}
}

if (!empty($_REQUEST['p_name']) and $_SESSION['me']) {
	if (!$db->add_parcours($_REQUEST['p_name'],$_SESSION['me'],$_REQUEST['p_type'],$_SESSION['track'],$_REQUEST['p_level'],$_REQUEST['p_time'])) {
		$feedback[] = array('num'=>-1,'msg'=>$db->mes[0]);
	} else {
		$_SESSION['track'] = array();
	}
} elseif (isset($_REQUEST['do']) and $_REQUEST['do'] == tra('Enregistrer')) {
	$focus['edit'] = "focus";
}
elseif (isset($_REQUEST['do']) and $_REQUEST['do'] == tra('Effacer')) {
	$focus['edit'] = "focus";
	unset($_SESSION['track']);
}
elseif (isset($_REQUEST['do']) and $_REQUEST['do'] == tra('Undo')) {
	$focus['edit'] = "focus";
	unset($_SESSION['track'][count($_SESSION['track'])-1]);
}

// on a un clic dans la carte de reference
if (isset($_REQUEST['ref_x']) or isset($_REQUEST['ref.x'])) {
	$refx = ($_REQUEST['ref_x']) ? $_REQUEST['ref_x'] : $_REQUEST['ref.x'];
	$refy = ($_REQUEST['ref_y']) ? $_REQUEST['ref_y'] : $_REQUEST['ref.y'];
	$wx=($ext[2]-$ext[0])/2; // demi-largeur en échelle carte
	$wy=($ext[3]-$ext[1])/2; // demi-hauteur en échelle carte
	$e_extent->setextent($extminxmf+$refx/$refwidth*($extmaxxmf-$extminxmf)-$wx,$extminymf+(1-$refy/$refheight)*($extmaxymf-$extminymf)-$wy,$extminxmf+$refx/$refwidth*($extmaxxmf-$extminxmf)+$wx,$extminymf+(1-$refy/$refheight)*($extmaxymf-$extminymf)+$wy);
	}

$e_map->zoompoint($zoom_factor,$e_click,$sizex,$sizey,$e_extent,$e_limit);
	
		
if (isset($filtre) and is_array($filtre) and count($filtre)) {
	// affichage des contours en noir de tous les parcours qqsoit la discipline
	// uniquement si échelle assez faible
	if ($e_map->scale < $minscaledispextparc) {
		$e_lay = ms_newLayerObj($e_map);
		$e_lay->set('name','parcoursline');
		$e_lay->set('status',MS_ON);
		$e_lay->set('connectiontype',MS_POSTGIS);
		$e_lay->set('connection',$db->connstr);
		$query = "parcours_geom from parcours";
		if (isset($wh) and is_array($wh) and count($wh)) {
			$e_lay->setFilter(implode(' and ',$wh));
		}
		$e_lay->set('data',$query);
		$e_lay->set('type',MS_LAYER_LINE);
		$e_cla = ms_newClassObj($e_lay);
		$e_sty = ms_newStyleObj($e_cla);
		$e_sty->set("symbolname","circle");
		$e_sty->set("size",$extparcwdth); 
		$e_sty->color->setRGB(0,0,0);
	} // fin si echelle assez grande pour afficher contours noirs

	// autre couche utilisée pour l'intérieur de la ligne, dont la couleur varie suivant la discipline	
	$e_lay2 = ms_newLayerObj($e_map);
	$e_lay2->set('name','parcourslineover');
	$e_lay2->set('status',MS_ON);
	$e_lay2->set('connectiontype',MS_POSTGIS);
	$e_lay2->set('connection',$db->connstr);
	$query = "parcours_geom from parcours";
	if (isset($wh) and is_array($wh) and count($wh)) {
		$e_lay2->setFilter(implode(' and ',$wh));
	}
	$e_lay2->set('data',$query);
	$e_lay2->set('type',MS_LAYER_LINE);
	$e_lay2->set('classitem','parcours_type');
		
	for ($extype=1;$extype<=count($types);$extype++) {
		$e_cla2[$extype] = ms_newClassObj($e_lay2);
		$e_cla2[$extype]->setExpression($extype);
		$e_sty2[$extype] = ms_newStyleObj($e_cla2[$extype]);
		$e_sty2[$extype]->set("symbolname","circle");
		$e_sty2[$extype]->set("size",$intparcwdth);
		$e_sty2[$extype]->color->setRGB(hexdec(substr($typescolor[$extype],0,2)),hexdec(substr($typescolor[$extype],2,2)),hexdec(substr($typescolor[$extype],4,2)));	
	}

	// couches de labels/pictos avec des couleurs différentes suivant les types
	$e_lay = ms_newLayerObj($e_map);
	$e_lay->set('name','parcours');
	$e_lay->set('status',MS_ON);
	$e_lay->set('labelcache',MS_ON); // par défaut

	$e_lay->set('connectiontype',MS_POSTGIS);
	$e_lay->set('connection',$db->connstr);
	$query = "parcours_start from parcours";
	if (isset($wh) and is_array($wh) and count($wh)) {
		$e_lay->setFilter(implode(' and ',$wh));
	}
	$e_lay->set('data',$query);
	$e_lay->set('type',MS_LAYER_POINT);
	$e_lay->set('labelitem','parcours_name');
	$e_lay->set('classitem','parcours_type');
	
	for ($extype=1;$extype<=count($types);$extype++) {
		$e_cla3[$extype] = ms_newClassObj($e_lay);
		$e_cla3[$extype]->set('name',$name[$extype]);
		$e_cla3[$extype]->setExpression($extype);
		$e_sty3[$extype] = ms_newStyleObj($e_cla3[$extype]);
		if (isset($e_map->scale) &&  $e_map->scale < $minscaledisplabels && $e_map->scale!=-1) {
			$e_lab[$extype] = $e_cla3[$extype]->label;
			$e_lab[$extype]->set("position",MS_AUTO);
			$e_lab[$extype]->backgroundshadowcolor->setRGB(200,200,200);

			$e_lab[$extype]->set("size",$parclabelsize);
			$e_lab[$extype]->set("type","truetype");
			$e_lab[$extype]->set("font",$parclabelfont);
			$e_lab[$extype]->color->setRGB(0,0,0);
			$e_lab[$extype]->backgroundcolor->setRGB(hexdec(substr($typescolor[$extype],0,2)),hexdec(substr($typescolor[$extype],2,2)),hexdec(substr($typescolor[$extype],4,2)));
		} // fin si echelle assez grande pour afficher les labels
		$e_sty3[$extype]->set("symbolname",$name[$extype]);
	} // fin boucle sur les types de parcours
}
// trace dessinée en temps réel en ligne
if (!empty($_SESSION['track'])) {
	$e_shape = ms_newShapeObj(MS_SHAPE_LINE);
	$e_line = ms_newLineObj();
	foreach($_SESSION['track'] as $coord) {
		list($x,$y) = split(' ',$coord);
		$e_line->addXY($x,$y);
	}
	$e_shape->add($e_line);
	
	$e_track2 = ms_newLayerObj($e_map);
	$e_track2->set('name','temptrackback');
	$e_track2->set('status',MS_ON);
	$e_track2->set('type',MS_LAYER_LINE);
	$e_track2->addFeature($e_shape);
	$e_class2 = ms_newClassObj($e_track2);
	$e_style2 = ms_newStyleObj($e_class2);
	$e_style2->color->setRGB(200,160,100);
	$e_style2->set("size",7);
	$e_style2->set("symbolname",'circle');

	$e_track = ms_newLayerObj($e_map);
	$e_track->set('name','temptrack');
	$e_track->set('status',MS_ON);
	$e_track->set('type',MS_LAYER_LINE);
	$e_track->addFeature($e_shape);
	$e_class = ms_newClassObj($e_track);
	$e_style = ms_newStyleObj($e_class);
	$e_style->color->setRGB(255,255,20);
	$e_style->set("size",3);
	$e_style->set("symbolname",'circle');

	$e_shapestart = ms_newShapeObj(MS_SHAPE_POINT);
	$e_line = ms_newLineObj();
	list($px,$py) = split(' ',$_SESSION['track'][0]);
	$e_line->addXY($px,$py);
	$e_shapestart->add($e_line);
	
	$e_track3 = ms_newLayerObj($e_map);
	$e_track3->set('name','temptrackstart');
	$e_track3->set('status',MS_ON);
	$e_track3->set('type',MS_LAYER_POINT);
	$e_track3->addFeature($e_shapestart);
	$e_class3 = ms_newClassObj($e_track3);
	$e_style3 = ms_newStyleObj($e_class3);
	$e_style3->set("symbolname",'flag2');
}


$e_image = $e_map->draw();
$image = $e_image->saveWebImage();
$e_ref = $e_map->drawreferencemap();
$refsrc = $e_ref->saveWebImage('MS_PNG',0,0,-1);

// reconstitue la légende avec les pictos
$legends = array();
for ($i=0; $i<$e_map->numlayers; $i++) {
	$layer = $e_map->getLayer($i);
	if ($layer->status != MS_OFF && $layer->type != MS_LAYER_QUERY) {
		for ($j=0; $j<$layer->numclasses; $j++) {
			$myClass = $layer->GetClass($j);
			if ($myClass->name) {
				$e_img = $myClass->createLegendIcon($e_map->keysizex, $e_map->keysizey);
				$legends[$myClass->name] = $e_img->saveWebImage('MS_PNG', 0, 0, 0);
			}
		}
	}
}
$smarty->assign('legends',$legends);

if (isset($filtre) and is_array($filtre) and count($filtre)) {
	/* calcule la liste des parcours correspondant aux critères de requête 
	et se trouvant dans la zone affichée
	calcule les coord xy (pix) des rectangles correspondant aux pictos
	définissant les zones cliquables dans la maparea
	*/
	$extminx = $e_map->extent->minx;
	$extminy = $e_map->extent->miny;
	$extmaxx = $e_map->extent->maxx;
	$extmaxy = $e_map->extent->maxy;

	$tracks = $db->get_parcours(array($extminx,$extminy,$extmaxx,$extmaxy),$filtre);
	for ($i=0;$i<count($tracks);$i++) {
		if (preg_match("/POINT\(([\.0-9]*) ([\.0-9]*)\)/",$tracks[$i]['coord'],$m)) {
			$xx = geo2pix($m[1],$extminx,$extmaxx,$sizex);
			$yy = geo2pix($m[2],$extmaxy,$extminy,$sizey);
			$tracks[$i]['rect'] = ($xx - 10) .','. ($yy - 10) .','. ($xx + 10) .','. ($yy + 10);
		}
	}
	$smarty->assign('tracks',$tracks);
} // fin si filtre défini

$smarty->assign('sizex',$sizex);
$smarty->assign('sizey',$sizey);
$smarty->assign('sizecheck',$sizecheck);
$smarty->assign('mapmargin',$mapmargin);
$smarty->assign('blockspc',$blockspc);
$smarty->assign('extent',"$extminx $extminy $extmaxx $extmaxy");
$scale = $e_map->scale;
$smarty->assign('scale',floor($scale));
$smarty->assign('refsrc',$refsrc);
$smarty->assign('refwidth',$refwidth);
$smarty->assign('refheight',$refheight);
$smarty->assign('focus',$focus);
if (isset($map_click)) $smarty->assign('map_click',$map_click);
$smarty->assign('mapimage',$image);
$smarty->assign('types',$types);
$smarty->assign('typescolor',$typescolor);
//$smarty->assign('icontypes',$icontypes);
$smarty->assign('times',$times);
$smarty->assign('levels',$levels);

$smarty->display("map.tpl");
echo "<div style='font-size:9px;padding:3px;'>". tra('Temps').' : '. elapsed_time()." s</div>";

?>
