<?php 
$title = "Cartographie";
$db = true;
include("setup.php");
checkfontlist(PROOT."/maps");

// valeurs a mettre en conf -----------
include_once("map_conf.inc");
// elles y sont 
// ------------------------------------

$mapfile = PROOT. "/maps/$mapfile";
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

if (isset($_REQUEST['act'])) {
	$act = $_REQUEST['act'];
} else {
	$act = 'nothing';
}
if (isset($_REQUEST['purge']) and $_REQUEST['purge'] == 'all') {
	$_SESSION['track'] = array();
}
$lay = array("fond");

if (isset($_REQUEST['filtre'])) {
	$filtre = $_REQUEST['filtre'];
	$_SESSION['filtre'] = array();
	foreach ($filtre as $f=>$v) {
		$_SESSION["filtre"][$f] = $v;
	}
} elseif (isset($_SESSION['filtre'])) {
	$filtre = $_SESSION['filtre'];
}
$smarty->assign('filtre',$filtre);

// ========================================================================

$e_map = ms_newMapObj($mapfile);

$extminx = $e_map->extent->minx;
$extminy = $e_map->extent->miny;
$extmaxx = $e_map->extent->maxx;
$extmaxy = $e_map->extent->maxy;

$e_limit = ms_newRectObj();
$e_limit->setextent($extminx,$extminy,$extmaxx,$extmaxy);

if (!empty($_REQUEST['extent'])) {
	list($extminx,$extminy,$extmaxx,$extmaxy) = split(' ',trim($_REQUEST['extent']));
}
$ext = array($extminx,$extminy,$extmaxx,$extmaxy);

$e_extent = ms_newRectObj();
$e_extent->setextent($ext[0],$ext[1],$ext[2],$ext[3]);

if (!isset($_REQUEST['size'])) {
	$sizex = $e_map->width;
	$sizey = $e_map->height;
} else {
	list($sizex,$sizey) = split('x',$_REQUEST['size']);
}
$sizecheck["{$sizex}x{$sizey}"] = " selected=\"selected\"";

$e_click = ms_newPointObj();
if (!empty($_REQUEST['ville'])) {
	$cities = $db->get_cities($_REQUEST['ville']);
	if (!$cities or count($cities) == 0) {
		$feedback[] = array('num'=>-1,'msg'=>sprintf(tra('Désolé, aucun nom de ville en Limousin ne commence par %s.'),$_REQUEST['ville']));
	} elseif (count($cities) == 1) {
		$_REQUEST = array();
		$_REQUEST['focusville'] = $cities[0]['nom'];
	} else {
		$smarty->assign('cities',$cities);
	}
}

if (isset($_REQUEST['focusville'])) {
	$city_info = $db->get_city_info($_REQUEST['focusville']);
	if (!$city_info) {
		$feedback[] = array('num'=>-1,'msg'=>sprintf(tra('Désolé, aucun nom de ville en Limousin ne correspond à %s.'),$_REQUEST['focusville']));
	} else {
		$smarty->assign('city_info',$city_info);
		preg_match("/POINT\(([\.0-9]*) ([\.0-9]*)\)/",$city_info[0]['xy'],$m);
		$e_rect = ms_newRectObj();
		$e_rect->setextent(floor($m[1]-$sf),floor($m[2]-$sf),floor($m[1]+$sf),floor($m[2]+$sf));
		$e_click->setXY(floor($sizex/2),floor($sizey/2),0);
		$e_map->zoompoint(1,$e_click,$sizex,$sizey,$e_rect,$e_limit);
	}
} elseif (isset($_REQUEST['size']) and isset($_REQUEST['resize']) and $_REQUEST['resize'] == "y") {
	$e_click->setXY(floor($sizex/2),floor($sizey/2),0);
	$e_map->zoompoint(1,$e_click,$sizex,$sizey,$e_extent,$e_limit);
	$_REQUEST['action'] = "travel";
	$clicked = TRUE;
} elseif (isset($_REQUEST['search']) and $_REQUEST['search'] == tra('Rechercher')) {
	$e_click->setXY(floor($sizex/2),floor($sizey/2),0);
	$e_map->zoompoint(1,$e_click,$sizex,$sizey,$e_extent,$e_limit);
	$clicked = false;
} elseif (isset($_REQUEST['pid'])) {
	$parcours_info = $db->get_parcours_info($_REQUEST['pid']);
	preg_match("/POLYGON\(\(([\.0-9]*) ([\.0-9]*),[\.0-9]* ([\.0-9]*),([\.0-9]*) [\.0-9]*,[\.0-9]* [\.0-9]*,[\.0-9]* [\.0-9]*\)\)/",$parcours_info['ext'],$m);		
	$d = (($m[4] - $m[1]) / 10);
	$b = (($m[3] - $m[2]) / 10);
	$e_extent->setextent($m[1] - $d,$m[2] - $d,$m[4] + $b,$m[3] + $d);
	$e_click->setXY(floor($sizex/2),floor($sizey/2),0);
	$e_map->zoompoint(1,$e_click,$sizex,$sizey,$e_extent,$e_limit);
	$clicked = false;
}

$e_map->set('width',$sizex);
$e_map->set('height',$sizey);
$smarty->assign('sizex',$sizex);
$smarty->assign('sizey',$sizey);
$smarty->assign('sizecheck',$sizecheck);
$smarty->assign('mapmargin',$mapmargin);
$smarty->assign('blockspc',$blockspc);

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

if ($click_x and $click_y) {
	$e_click->setXY($click_x,$click_y,0);
	$map_click['x'] = $extminx + pix2geo($click_x,$extminx,$extmaxx,$sizex);
	$map_click['y'] = $extmaxy - pix2geo($click_y,$extminy,$extmaxy,$sizey);
	$clicked = TRUE;
} elseif (!empty($_REQUEST['dir'])) {
	list($fx,$fy) = $_REQUEST['dir'];
	$ffx['l'] = $ffx['t'] = -1;
	$ffx['c'] = 0;
	$ffx['r'] = $ffx['b'] = 1;
	$e_click->setXY(floor(($sizex/2)+($ffx[$fx]*$sizex/2)),floor(($sizey/2)+($ffx[$fy]*$sizey/2)),0);
	$_REQUEST['action'] = "travel";
	$clicked = TRUE;
	$map_click = array();
} else {
	$e_click->setXY(floor($sizex/2),floor($sizey/2),0);
	$clicked = FALSE;
	$map_click = array();
}
$focus = array();
if ($clicked) {
	if (isset($_REQUEST['action'])) {
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
}

if (!empty($_REQUEST['p_name']) and $_SESSION['me']) {
	if (!$db->add_parcours($_REQUEST['p_name'],$_SESSION['me'],$_REQUEST['p_type'],$_SESSION['track'],$_REQUEST['p_level'],$_REQUEST['p_time'])) {
		$feedback[] = array('num'=>-1,'msg'=>$db->mes[0]);
	} else {
		$_SESSION['track'] = array();
	}
	$e_map->zoompoint(1,$e_click,$sizex,$sizey,$e_extent,$e_limit);
} elseif (isset($_REQUEST['do']) and $_REQUEST['do'] == tra('Enregistrer')) {
	$e_map->zoompoint(1,$e_click,$sizex,$sizey,$e_extent,$e_limit);
	$focus['edit'] = "focus";
}

$scale_r=$rapechelpix*($extmaxx-$extminx)/$sizex; // echelle recalculée (empirique ...)
echo "scale_r=".$scale_r;
if (isset($filtre) and is_array($filtre)) {
	foreach ($filtre as $f=>$v) {
		if (!empty($v)) {
			$wh[] = "parcours_$f=$v";
		}
	}
	$where = '';
	
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
	
	$extype=1;
	$e_cla2a = ms_newClassObj($e_lay2);
	$e_cla2a->setExpression($extype);
	$e_sty2a = ms_newStyleObj($e_cla2a);
	$e_sty2a->set("symbolname","circle");
	$e_sty2a->set("size",$intparcwdth);
	$e_sty2a->color->setRGB(hexdec(substr($typescolor[$extype],0,2)),hexdec(substr($typescolor[$extype],2,2)),hexdec(substr($typescolor[$extype],4,2)));
	
	$extype=2;
	$e_cla2b = ms_newClassObj($e_lay2);
	$e_cla2b->setExpression($extype);
	$e_sty2b = ms_newStyleObj($e_cla2b);
	$e_sty2b->set("symbolname","circle");
	$e_sty2b->set("size",$intparcwdth);
	$e_sty2b->color->setRGB(hexdec(substr($typescolor[$extype],0,2)),hexdec(substr($typescolor[$extype],2,2)),hexdec(substr($typescolor[$extype],4,2)));

	$extype=3;
	$e_cla2c = ms_newClassObj($e_lay2);
	$e_cla2c->setExpression($extype);
	$e_sty2c = ms_newStyleObj($e_cla2c);
	$e_sty2c->set("symbolname","circle");
	$e_sty2c->set("size",$intparcwdth);
	$e_sty2c->color->setRGB(hexdec(substr($typescolor[$extype],0,2)),hexdec(substr($typescolor[$extype],2,2)),hexdec(substr($typescolor[$extype],4,2)));
	
	$extype=4;
	$e_cla2d = ms_newclassobj($e_lay2);
	$e_cla2d->setExpression($extype);
	$e_sty2d = ms_newstyleobj($e_cla2d);
	$e_sty2d->set("symbolname","circle");
	$e_sty2d->set("size",$intparcwdth);
	$e_sty2d->color->setRGB(hexdec(substr($typescolor[$extype],0,2)),hexdec(substr($typescolor[$extype],2,2)),hexdec(substr($typescolor[$extype],4,2)));
	
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
	
	$extype='1';
	$e_claa = ms_newClassObj($e_lay);
	$e_claa->set('name','Pedestre');
	$e_claa->setExpression($extype);
	$e_stya = ms_newStyleObj($e_claa);
	$e_laba = $e_claa->label;
	$e_laba->set("position",MS_AUTO);
	$e_laba->backgroundshadowcolor->setRGB(200,200,200);

	$e_laba->set("size",$parclabelsize);
	$e_laba->set("type","truetype");
	$e_laba->set("font",$parclabelfont);
	$e_laba->color->setRGB(0,0,0);
	$e_laba->backgroundcolor->setRGB(hexdec(substr($typescolor[$extype],0,2)),hexdec(substr($typescolor[$extype],2,2)),hexdec(substr($typescolor[$extype],4,2)));
	$e_stya->set("symbolname","marche");

	$extype='2';
	$e_clab = ms_newClassObj($e_lay);
	$e_clab->set('name','Equestre');
	$e_clab->setExpression($extype);
	$e_styb = ms_newStyleObj($e_clab);
	$e_labb = $e_clab->label;
	$e_labb->set("position",MS_AUTO);
	$e_labb->backgroundshadowcolor->setRGB(200,200,200);

	$e_labb->set("size",$parclabelsize);
	$e_labb->set("type","truetype");
	$e_labb->set("font",$parclabelfont);
	$e_labb->color->setRGB(0,0,0);
	$e_labb->backgroundcolor->setRGB(hexdec(substr($typescolor[$extype],0,2)),hexdec(substr($typescolor[$extype],2,2)),hexdec(substr($typescolor[$extype],4,2)));
	$e_styb->set("symbolname","cheval");

	$extype='3';
	$e_clac = ms_newClassObj($e_lay);
	$e_clac->set('name','VTT');
	$e_clac->setExpression($extype);
	$e_styc = ms_newStyleObj($e_clac);
	$e_labc = $e_clac->label;
	$e_labc->set("position",MS_AUTO);
	$e_labc->backgroundshadowcolor->setRGB(200,200,200);

	$e_labc->set("size",$parclabelsize);
	$e_labc->set("type","truetype");
	$e_labc->set("font",$parclabelfont);
	$e_labc->color->setRGB(0,0,0);
	$e_labc->backgroundcolor->setRGB(hexdec(substr($typescolor[$extype],0,2)),hexdec(substr($typescolor[$extype],2,2)),hexdec(substr($typescolor[$extype],4,2)));
	$e_styc->set("symbolname","vtt");

	$extype='4';
	$e_clad = ms_newClassObj($e_lay);
	$e_clad->set('name','Canoe-kayak');
	$e_clad->setExpression($extype);
	$e_styd = ms_newStyleObj($e_clad);
	$e_labd = $e_clad->label;
	$e_labd->set("position",MS_AUTO);
	$e_labd->backgroundshadowcolor->setRGB(200,200,200);

	$e_labd->set("size",$parclabelsize);
	$e_labd->set("type","truetype");
	$e_labd->set("font",$parclabelfont);
	$e_labd->color->setRGB(0,0,0);
	$e_labd->backgroundcolor->setRGB(hexdec(substr($typescolor[$extype],0,2)),hexdec(substr($typescolor[$extype],2,2)),hexdec(substr($typescolor[$extype],4,2)));
	$e_styd->set("symbolname","canoe");

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

$smarty->assign('extent',"$extminx $extminy $extmaxx $extmaxy");
$scale = $e_map->scale;
$smarty->assign('scale',$scale);
$smarty->assign('refsrc',$refsrc);
$smarty->assign('focus',$focus);
$smarty->assign('map_click',$map_click);
$smarty->assign('mapimage',$image);
$smarty->assign('types',$types);
$smarty->assign('typescolor',$typescolor);
//$smarty->assign('icontypes',$icontypes);
$smarty->assign('times',$times);
$smarty->assign('levels',$levels);

$smarty->display("map.tpl");
echo "<small>".elapsed_time()."</small>";
?>
