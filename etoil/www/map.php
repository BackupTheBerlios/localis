<?php 
$title = "Cartographie";
$db = true;
include("setup.php");
checkfontlist(PROOT."/maps");

$mapfile = PROOT. "/maps/limousin.map";
if (isset($_REQUEST['x'])) {
	$click_x = $_REQUEST['x'];
	$click_y = $_REQUEST['y'];
} else {
	$click_x = $click_y = false;
}
if (isset($_REQUEST['ref_x']) or isset($_REQUEST['ref.x'])) {
	$refx = ($_REQUEST['ref_x']) ? $_REQUEST['ref_x'] : $_REQUEST['ref.x'];
	$refy = ($_REQUEST['ref_y']) ? $_REQUEST['ref_y'] : $_REQUEST['ref.y'];
} else {
	$refx = $refy = false;
}
if (isset($_REQUEST['forcescale']) or isset($_REQUEST['scale'])) {
	$scl = ($_REQUEST['forcescale']) ? $_REQUEST['forcescale'] : $_REQUEST['scale'];
} else {
	$scl = 1;
}
if (isset($_REQUEST['act'])) {
	$act = $_REQUEST['act'];
} else {
	$act = 'nothing';
}
if (isset($_REQUEST['purge']) and $_REQUEST['purge'] == 'all') {
	$_SESSION['track'] = array();
}
$lay = array("fond");

$moyens[1] = "Pédestre";
$moyens[2] = "Equestre";
$moyens[3] = "Cyclable";
$moyens[4] = "Kayak";
$smarty->assign('moyens',$moyens);

$durees[1] = "moins d'une demi-heure";
$durees[2] = "moins d'une heure";
$durees[3] = "une à deux heures";
$durees[4] = "plus de deux heures";
$smarty->assign('durees',$durees);

$difficultes[1] = "1";
$difficultes[2] = "2";
$difficultes[3] = "3";
$difficultes[4] = "4";
$difficultes[5] = "5";
$smarty->assign('difficultes',$difficultes);

if (isset($_REQUEST['filtre'])) {
	$filtre = $_REQUEST['filtre'];
	$smarty->assign('filtre',$filtre);
}

// ========================================================================

$e_map = ms_newMapObj($mapfile);

$extminx = $e_map->extent->minx;
$extminy = $e_map->extent->miny;
$extmaxx = $e_map->extent->maxx;
$extmaxy = $e_map->extent->maxy;

$e_limit = ms_newRectObj();
$e_limit->setextent($extminx,$extminy,$extmaxx,$extmaxy);

if (isset($_REQUEST['extent'])) {
	list($extminx,$extminy,$extmaxx,$extmaxy) = split(' ',trim($_REQUEST['extent']));
}
$ext = array($extminx,$extminy,$extmaxx,$extmaxy);

$e_extent = ms_newRectObj();
$e_extent->setextent($ext[0],$ext[1],$ext[2],$ext[3]);

if (isset($_REQUEST['size'])) {
	list($sizex,$sizey) = split('x',$_REQUEST['size']);
	$sizecheck["{$_REQUEST['size']}"] = " selected=\"selected\"";
} else {
	$sizex = $e_map->width;
	$sizey = $e_map->height;
	$sizecheck["{$sizex}x{$sizey}"] = " selected=\"selected\"";
}

$e_map->set('width',$sizex);
$e_map->set('height',$sizey);
$smarty->assign('sizex',$sizex);
$smarty->assign('sizey',$sizey);
$smarty->assign('sizecheck',$sizecheck);
$smarty->assign('mapmargin',12);

// ========================================================================

$layers = $e_map->getAllGroupNames();
foreach ($layers as $l) {
	$maplayer[] = $l;
	$tl = $e_map->getLayersIndexByGroup($l);
	if ((is_array($tl)) and (!in_array($l,$lay))) {
		foreach ($tl as $t) {
			$e_layer = $e_map->getLayer($t);
			$e_layer->set("status",MS_OFF);
		}
	}			
}

$e_click = ms_newPointObj();
if ($click_x and $click_y) {
	$e_click->setXY($click_x,$click_y,0);
	$map_click['x'] = $extminx + pix2geo($click_x,$extminx,$extmaxx,$sizex);
	$map_click['y'] = $extmaxy - pix2geo($click_y,$extminy,$extmaxy,$sizey);
	$clicked = TRUE;
} else {
	$e_click->setXY(floor($sizex/2),floor($sizey/2),0);
	$clicked = FALSE;
	$map_click = array();
}
$focus = array();
if ($clicked and isset($_REQUEST['action'])) {
	if ($_REQUEST['action'] == "zoomin") {
		$e_map->zoompoint(2,$e_click,$sizex,$sizey,$e_extent,$e_limit);
		$focus['zoomin'] = "focus";
	} elseif ($_REQUEST['action'] == "zoomout") {
		$e_map->zoompoint(-2,$e_click,$sizex,$sizey,$e_extent,$e_limit);
		$focus['zoomout'] = "focus";
	} elseif ($_REQUEST['action'] == "travel") {
		$e_map->zoompoint(1,$e_click,$sizex,$sizey,$e_extent,$e_limit);
		$focus['travel'] = "focus";
	} elseif ($_REQUEST['action'] == "edit" and isset($_SESSION['admin']) and $_SESSION['admin']) {
		$e_click->setXY(floor($sizex/2),floor($sizey/2),0);
		$e_map->zoompoint(1,$e_click,$sizex,$sizey,$e_extent,$e_limit);
		$focus['edit'] = "focus";
		$_SESSION['track'][] = $map_click['x']." ".$map_click['y'];
	}
}

if (isset($_REQUEST['p_name']) and $_SESSION['me']) {
	if (!$db->add_parcours($_REQUEST['p_name'],$_SESSION['me'],$_REQUEST['p_type'],$_SESSION['track'],$_REQUEST['p_difficulte'],$_REQUEST['p_duree'])) {
		$feedback[] = array('num'=>-1,'msg'=>$db->mes[0]);
	} else {
		$_SESSION['track'] = array();
	}
}

if (isset($_REQUEST['action']) and $_REQUEST['action'] == tra('Rechercher')) {
	//$where = "where parcours_type=1";
	$where = '';
	$e_lay = ms_newLayerObj($e_map);
	$e_lay->set('name','parcours');
	$e_lay->set('status',MS_ON);
	$e_lay->set('connectiontype',MS_POSTGIS);
	$e_lay->set('connection',$db->connstr);
	$e_lay->set('data',"parcours_start from parcours");
	$e_lay->set('type',MS_LAYER_POINT);
	$e_lay->set('labelitem','parcours_name');
	$e_cla = ms_newClassObj($e_lay);
	$e_sty = ms_newStyleObj($e_cla);
	$e_lab = $e_cla->label;
	$e_lab->set("position",MS_CC);
	$e_lab->set("size",9);
	$e_lab->color->setRGB(128,0,0);
	$e_lab->backgroundcolor->setRGB(255,255,255);
	$e_sty->set("size",8);
	$e_sty->set("symbolname","circle");
	$e_sty->color->setRGB(128,0,0);
}

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
	$e_style->color->setRGB(255,255,255);
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
$e_legend = $e_map->drawLegend();
$legsrc = $e_legend->savewebimage('MS_PNG',0,0,-1);

$extminx = $e_map->extent->minx;
$extminy = $e_map->extent->miny;
$extmaxx = $e_map->extent->maxx;
$extmaxy = $e_map->extent->maxy;
$smarty->assign('extent',"$extminx $extminy $extmaxx $extmaxy");
$smarty->assign('refsrc',$refsrc);
$smarty->assign('legsrc',$legsrc);
$smarty->assign('focus',$focus);
$smarty->assign('map_click',$map_click);
$smarty->assign('mapimage',$image);
$smarty->display("map.tpl");
echo elapsed_time();
?>
