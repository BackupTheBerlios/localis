<?php 
$title = "Cartographie";
$db = true;
include("setup.php");

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
$lay = array("fond");

$e_map = ms_newMapObj($mapfile);

// ========================================================================

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
	}
}

$e_layer = ms_newLayerObj($e_map);
$e_layer->set('name','tracks');
$e_layer->set('status',MS_ON);
$e_layer->set('connectiontype',MS_POSTGIS);
$e_layer->set('connectiontype',$db->connstr);
$e_layer->set('data',"point_geom from points where point_parcours_id=1");
$e_layer->set('type',MS_LAYER_POINT);
$e_layer->set('labelitem','point_time');
$e_layer->set('connectiontype',$db->connstr);
$e_class = ms_newClassObj($e_layer);
$e_label = $e_class->label;
$e_label->set("position",MS_CC);
$e_style = ms_newStyleObj($e_class);
$e_style->set("size",8);
$e_style->outlinecolor->setRGB(128,0,0);

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
