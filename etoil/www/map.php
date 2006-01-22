<?php 
$title = "Cartographie";
$db = true;
include("setup.php");
include_once(PROOT."/libs/lei_fct.inc"); // fonctions php
require_once("dl3tree.inc"); // fichier partagï¿½contenant l'objet permettant de gï¿½ï¿½er des arboresences

//debug ("_REQUEST");
//debug ("_SESSION");
checkfontlist(PROOT."/maps");
//include_once(PROOT."/libs/conf.php"); fait ds le setup

// sur le proto, on n'affiche la carte que si on est logg? avec un profil >=1 et que le code profil
$bool_map_disp=(!empty($_SESSION['me']) && $_SESSION['profile']>=1 ) || $anonym_disp_maps;
$smarty->assign('bool_map_disp',$bool_map_disp);
$smarty->assign('bool_lei_stat',RecupLib("conf","name","value","lei_stat"));
$smarty->assign('url_lei_stat',RecupLib("conf","name","value","url_lei_stat"));


if (isset($_REQUEST['x'])) {
	$click_x = $_REQUEST['x'];
	$click_y = $_REQUEST['y'];
} else {
	$click_x = $click_y = false;
}

// enlevé: ne servait que quand on arrivait sur la carto pour la première fois
// maintenant c'est le zoom pardéfaut qui est sélectionné
//if (!isset($_REQUEST['action']))  $_REQUEST['action'] = "travel";

$zoom_factor=1; // défaut

if (isset($_REQUEST['purge']) and $_REQUEST['purge'] == 'all') {
	$_SESSION['track'] = array();
}
if (isset($_REQUEST['filtre'])) {
	$filtre = $_REQUEST['filtre'];
	$_SESSION['filtre'] = array();
	foreach ($filtre as $f=>$v) {
		$_SESSION['filtre'][$f] = $v; // ex: SESSION[filtre][discp]="1" (pédestre)
	}
	$_SESSION['discp_c']=$_SESSION['filtre']['discp'];
} elseif (isset($_SESSION['filtre'])) {
	$filtre = $_SESSION['filtre'];
	
//} else { $filtre=array();
}
if ($_REQUEST['pid']!="") { // mode affichage parcours unique
	$_SESSION['pid']=$_REQUEST['pid'];
	}
elseif ($_REQUEST['notunique']=="true") unset($_SESSION['pid']);

// mode affichage parcours unique
if ($_SESSION['pid']) {
	// inclus ce qui était au départ la popup
	include ("pop_det_parc.php");
}

$discp_c=$_SESSION['discp_c'];


if ($bool_disp_lay_LEI) {
		if (!MSIE) {
			$LEI_Tree=new dltreeObj;
			$ChemImgTree="img/jstree/";
			$LEI_Tree->dispckbox=true;
			$LEI_Tree->imgfopen=$ChemImgTree.'folderOpen.gif'; // nom des fichiers images symoles
			$LEI_Tree->imgfcloseplus =$ChemImgTree.'folderClosedplus.gif';
			$LEI_Tree->imgfclose =$ChemImgTree.'folderClosed.gif';
			
			//$GLOBALS["TSFE"]->setJS("toto","alert('coucoui')");
			// déclaration des variables JS
			
			$smarty->assign('DL3TJSVarsInit',$LEI_Tree->echDL3TJSVarsInit(true));
			// declaration des fonctions JS
			$smarty->assign('DL3TJSFunctions',$LEI_Tree->echDL3TJSFunctions(true));
			// declaration des styles CSS
			$smarty->assign('DL3TStyles',$LEI_Tree->echDL3TStyles(true));
			
			$lei_obj=new lei_acc; // nouvel objet d'acces LEI
			$lei_obj->GenLeiCatTree(&$LEI_Tree);
			
			$smarty->assign('DL3TJStbChilds',$LEI_Tree->echDL3TJStbChilds(true));
			$smarty->assign('tree_lei',$lei_obj->strTree);
		} 
}
//print_r ($tb_lei_selidcat);

/*if (isset($_REQUEST['rq_lei_f_idcat'])) {
	$_SESSION['rq_lei_f_idcat'] = $_REQUEST['rq_lei_f_idcat'];
} elseif (isset($_SESSION['rq_lei_f_idcat'])) {
	 $_REQUEST['rq_lei_f_idcat']=$_SESSION['rq_lei_f_idcat'];
}*/

// ========================================================================
// special hack: si paramètre spécial spcsc25=tux129 pass? en get (par l'url)
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


// ces param?tres sont r?cup?r?s par d?faut dans le mapfile static
// ils seront maj si la variable extent est d?finie
// celle-ci est pass?e en hidden
$extminx = $extminxmf = $e_map->extent->minx;
$extminy = $extminymf = $e_map->extent->miny;
$extmaxx = $extmaxxmf = $e_map->extent->maxx;
$extmaxy = $extmaxymf = $e_map->extent->maxy;

// fonction qui d?sactivait dans le mapfile toutes les couches qui
// ne font pas partie du groupe "fond"
// Pourquoi ?????
/*$lay = array("fond");
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
*/

$e_limit = ms_newRectObj();
$e_limit->setextent($extminx,$extminy,$extmaxx,$extmaxy);

if (!empty($_REQUEST['extent'])) { // extent est une var passée en input hidden 
	list($extminx,$extminy,$extmaxx,$extmaxy) = split(' ',trim(urldecode($_REQUEST['extent'])));
} else {
	unset($_SESSION['pid']);
	unset($_REQUEST['pid']);
	$focus = array();
	$focus["zoomin"]="focus";
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



$e_click = ms_newPointObj(); // objet de pointage
$e_click->setXY(floor($sizex/2),floor($sizey/2),0); // par d?faut, comme un clic au centre

// au cas ou fichier trk téléchargé
if (!empty($_FILES['trackfileimp']['name'])) {
//debug("_FILES");
echo (import_track($_FILES['trackfileimp']['tmp_name'],"trk","wgs84"));

unlink($_FILES['trackfileimp']['tmp_name']); // efface le fichier t?l?charg?
}

// recherche des villes correspondant aux crit?res
if (!empty($_REQUEST['ville'])) {
	$cities = $db->get_cities($_REQUEST['ville'],$deptsregion); // filtre rajout? pour les depts de la r?gion
	if (!$cities or count($cities) == 0) {
		$feedback[] = array('num'=>-1,'msg'=>sprintf(tra('Désolé, aucun nom de ville en Limousin ne contient %s.'),$_REQUEST['ville']));
	} elseif (count($cities) == 1) {
		$_REQUEST['focusville'] = $cities[0]['nom'];
		$_REQUEST['idfocusville'] = $cities[0]['id'];

	} else {
		$smarty->assign('cities',$cities);
	}
}
// ne sert à rien pour l'instant
$action_OK=false; // par d?faut, l'action(zoom, travel) qui a le focus n'est PAS appliqu?e
// il peut y avoir plein d'autres actions (recherche, resize, etc ..)

if (isset($_REQUEST['focusville'])) {
	$city_info = $db->get_city_info($_REQUEST['idfocusville']);
	if (!$city_info) {
		$feedback[] = array('num'=>-1,'msg'=>sprintf(tra('Désolé, aucun nom de ville en Limousin ne correspond à %s.'),$_REQUEST['focusville']));
	} else {
		$smarty->assign('city_info',$city_info);
		//debug ("city_info");
		preg_match("/POINT\(([\.0-9]*) ([\.0-9]*)\)/",$city_info[0]['xy'],$m);
		// ce coef de 1.33 est d?termin? par empirisme; sinon ?a d?cale la carte.
		$m[1] += 1.33 * $sf ; //8100;
		$m[2] -=  1.33 * $sf; //8000;
		$e_extent->setextent(floor($m[1] - $sf),floor($m[2] - $sf),floor($m[1] + $sf),floor($m[2] + $sf));
		$_SESSION['zooml']=$zlfv; // facteur de zoom pr?d?fini autour d'un focus ville (2)
		$zoom_factor=1;
	}
} elseif ($_REQUEST['pid']!="") {
	$parcours_info = $db->get_parcours_info($_REQUEST['pid']);
	preg_match("/POLYGON\(\(([\.0-9]*) ([\.0-9]*),[\.0-9]* ([\.0-9]*),([\.0-9]*) [\.0-9]*,[\.0-9]* [\.0-9]*,[\.0-9]* [\.0-9]*\)\)/",$parcours_info['ext'],$m);
	$d = (($m[4] - $m[1]) / $pcarpc); //$pcarpc=% autour du parcours
	$b = (($m[3] - $m[2]) / $pcarpc);
	$e_extent->setextent($m[1] - $d,$m[2] - $d,$m[4] + $b,$m[3] + $d);
} elseif (isset($_REQUEST['action']) && $_REQUEST['action'] == "zoomout") { // si zoom out, on zoome out sans attendre le click sur la carte, on fait comme si on avait cliqu? au centre
	$click_x=floor($sizex/2);
	$click_y=floor($sizey/2);
	$zoom_factor=0 - $zoom2x;
} 

if ($click_x and $click_y) { // click "normal" dans la carte 
	$map_click['x'] = floor($extminx + pix2geo($click_x,$extminx,$extmaxx,$sizex));
	$map_click['y'] = floor($extmaxy - pix2geo($click_y,$extminy,$extmaxy,$sizey));
	$e_click->setXY($click_x,$click_y,0);
}
// cause soucis avec IE, change la fa?on de traiter les clics sur les fl?ches de dir
// lors d'un clic sur une input type=img name=dir value="titi", IE n'envoie que les variables dir_x et dir_y (coord en pixels du clic sur l'immage, et (contrairement ? firefox) PAS le couple variable=valeur dir=titi
$dx=$dy=0;
if (isset($_REQUEST['dir_lt_x'])) {$dx=-1;$dy=-1;}
if (isset($_REQUEST['dir_ct_x'])) {$dx= 0;$dy=-1;}
if (isset($_REQUEST['dir_rt_x'])) {$dx= 1;$dy=-1;}
if (isset($_REQUEST['dir_lc_x'])) {$dx=-1;$dy= 0;}
if (isset($_REQUEST['dir_rc_x'])) {$dx= 1;$dy= 0;}
if (isset($_REQUEST['dir_lb_x'])) {$dx=-1;$dy= 1;}
if (isset($_REQUEST['dir_cb_x'])) {$dx= 0;$dy= 1;}
if (isset($_REQUEST['dir_rb_x'])) {$dx= 1;$dy= 1;}

if ($dx!=0 || $dy!=0) { // clic sur les fleches de dir autour: on simule un clic..
	$zoom_factor=1;
	$e_click->setXY(floor(($sizex/2)+($dx*$sizex/$coef_fd)),floor(($sizey/2)+($dy*$sizey/$coef_fd)),0);
}

$focus = array();
if (isset($_REQUEST['action'])) {
	if ($_REQUEST['action'] == "zoomin") {
		if (isset($map_click)) $zoom_factor=$zoom2x;
		$focus['zoomin'] = "focus";
	} elseif ($_REQUEST['action'] == "zoomout") {
		if (isset($map_click)) $zoom_factor=0 - $zoom2x;
		$focus['zoomout'] = "focus";
	} elseif ($_REQUEST['action'] == "travel") {
		$focus['travel'] = "focus";
	} elseif ($_REQUEST['action'] == "edit" and isset($_SESSION['admin']) and $_SESSION['admin']) {
		$focus['edit'] = "focus";
		if (isset($map_click)) $_SESSION['track'][] = $map_click['x']." ".$map_click['y'];
	}
}

if (!empty($_REQUEST['p_name']) and $_SESSION['me']) { // enregistrement d'une track trac?e en bdd
	
	if (!$db->add_parcours($_REQUEST['p_name'],$_SESSION['me'],$_REQUEST['p_discp'],$_SESSION['track'],$_REQUEST['p_level'],$_REQUEST['p_time'])) {
		$feedback[] = array('num'=>-1,'msg'=>$db->mes[0]);
	} else {
		$_SESSION['track'] = array(); // vide tableau trac?
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

// clic dans la carte de reference
if (isset($_REQUEST['ref_x']) or isset($_REQUEST['ref.x'])) {
	$refx = ($_REQUEST['ref_x']) ? $_REQUEST['ref_x'] : $_REQUEST['ref.x'];
	$refy = ($_REQUEST['ref_y']) ? $_REQUEST['ref_y'] : $_REQUEST['ref.y'];
	$wx=($ext[2]-$ext[0])/2; // demi-largeur en ?chelle carte
	$wy=($ext[3]-$ext[1])/2; // demi-hauteur en ?chelle carte
	$e_extent->setextent($extminxmf+$refx/$refwidth*($extmaxxmf-$extminxmf)-$wx,$extminymf+(1-$refy/$refheight)*($extmaxymf-$extminymf)-$wy,$extminxmf+$refx/$refwidth*($extmaxxmf-$extminxmf)+$wx,$extminymf+(1-$refy/$refheight)*($extmaxymf-$extminymf)+$wy);
	}
// ************************************************************************

if ($bool_disp_zoomp) { // choix ancienne m?thode de zoom / nouvelle
	//if (empty($_REQUEST['extent']) && empty($_REQUEST['idfocusville'])) {
	if (empty($_REQUEST['extent'])) {

		// ancienne m?thode, conserv?e quand recadrage uniquement
		$e_map->zoompoint($zoom_factor,$e_click,$sizex,$sizey,$e_extent,$e_limit);
	} else  {
	// maintenant on se cale sur les niveaux de zoom pr?d?finis
	//void zoomscale(double nScale, pointObj oPixelPos, int nImageWidth, int nImageHeight, rectObj oGeorefExt)
	
	$zooml=($_SESSION['zooml']!="" ?  $_SESSION['zooml'] : 0);
	$zooml=r_zoompref($zooml,$zoom_factor);
	//debug ("zooml");
	//debug ("zoom_factor");
	$_SESSION['zooml']=$zooml;
	
	$zoomc=($_REQUEST['zoomc']>0 ? $_REQUEST['zoomc'] : $tbzoomd[$zooml]); // en admin (uniqt) on peut entrer en facteur de zoom
	
	if ($e_map->scale >= ($tbzoomd[0]-50) || $zoomc>= ($tbzoomd[0]-50)) { // si zoom mini, on recadre automatiquement 
		unset($focus);
		$focus['zoomin'] = "focus";
		$e_click->setXY(floor($sizex/2),floor($sizey/2),0); // par d?faut, comme un clic au centre
		$e_extent->setextent($extminxmf,$extminymf,$extmaxxmf,$extmaxymf);
	}
	$e_map->zoomscale($zoomc,$e_click,$sizex,$sizey,$e_extent);
		
	}
} else $e_map->zoompoint($zoom_factor,$e_click,$sizex,$sizey,$e_extent,$e_limit);

//recalcul du facteur de zoom le plus proche au cas o? il ai ?t? zapp?
$_SESSION['zooml']=recalczl($e_map->scale);
//echo "zooml: ".$_SESSION['zooml'];

// passage de l'extent au map.tpl
$extminx = floor($e_map->extent->minx);
$extminy = floor($e_map->extent->miny);
$extmaxx = floor($e_map->extent->maxx);
$extmaxy = floor($e_map->extent->maxy);
// l'extent est ensuite pass? par une variable cach?e ds map.tpl
$smarty->assign('extent',urlencode("$extminx $extminy $extmaxx $extmaxy"));


// affichage des parcours
if (isset($filtre) and is_array($filtre) and count($filtre) and $filtre["discp"]!="none") {
	$smarty->assign('filtre',$filtre);
	
	/* calcule la liste des parcours correspondant aux crit?res de requ?te 
	et se trouvant dans la zone affich?e */
	
	// c'est dans cette fonction qu'en MAJ $_SESSION[where_parc] 
	$tracks = $db->get_parcours(array($extminx,$extminy,$extmaxx,$extmaxy),$filtre);
	//echo $_SESSION['where_parc'];

	if ($e_map->scale < $minscaledispictos) {
	/*calcule les coord xy (pix) des rectangles correspondant aux pictos
	d?finissant les zones cliquables dans la maparea
	*/
		for ($i=0;$i<count($tracks);$i++) {
			if (preg_match("/POINT\(([\.0-9]*) ([\.0-9]*)\)/",$tracks[$i]['coord'],$m)) {
				$xx = geo2pix($m[1],$extminx,$extmaxx,$sizex);
				$yy = geo2pix($m[2],$extmaxy,$extminy,$sizey);
				$tracks[$i]['rect'] = ($xx - $xd2pp) .','. ($yy - $yd2pp) .','. ($xx + $xd2pp) .','. ($yy + $yd2pp);
			}
		}
	}
	//debug("tracks");
	$smarty->assign('tracks',$tracks);
	
	// calcul du where parcours
	// => nom_champ_bdd=parcours_$f
	$where_parc='';
	if ($_SESSION['pid']!="") {
		$where_parc="parcours_id=".$_SESSION['pid'];
	}
	else { // pas de parcours unique
		
		$where_parc=$_SESSION['where_parc'];
		/*foreach ($filtre as $f=>$v) {
			if (!empty($v)) $where_parc.= "parcours_$f=$v"." AND ";
		}
		if ($where_parc!='') $where_parc=substr($where_parc,0, strlen($where_parc) -5); 
		*/
		
	}
	
	// affichage des contours en noir de tous les parcours qqsoit la discipline
	// ce uniquement si ?chelle assez faible
	
	if ($e_map->scale < $minscaledispextparc) {
		$e_lay = ms_newLayerObj($e_map);
		$e_lay->set('name','parcoursline');
		$e_lay->set('status',MS_ON);
		$e_lay->set('connectiontype',MS_POSTGIS);
		$e_lay->set('connection',$db->connstr);
		$query = "parcours_geom from parcours";
		if ($where_parc!="")	$e_lay->setFilter($where_parc);
		$e_lay->set('data',$query);
		$e_lay->set('type',MS_LAYER_LINE);
		$e_cla = ms_newClassObj($e_lay);
		$e_sty = ms_newStyleObj($e_cla);
		$e_sty->set("symbolname","circle");
		$e_sty->set("size",$extparcwdth); 
		$e_sty->color->setRGB(0,0,0);
		
		$e_lay->set('labelitem','parcours_id');
		$e_lay->set('labelcache',MS_ON); // par d?faut

		// label
		$e_labl=$e_cla->label;
		$e_labl->set("position",MS_AUTO);
		$e_labl->set("angle",MS_AUTO);
		$e_labl->set("size",10);
		//$e_labl->set("mindistance",50);
		$e_labl->set("minfeaturesize",50);
		
		// $e_labl->set("buffer",3); sert ? rien
		$e_labl->set("force",MS_TRUE);
		$e_labl->set("type","truetype");
		$e_labl->set("font",$parclabelfont);
		$e_labl->color->setRGB(0,0,0);
		$e_labl->backgroundcolor->setRGB(hexdec(substr($discpcolor[$discp_c],0,2)),hexdec(substr($discpcolor[$discp_c],2,2)),hexdec(substr($discpcolor[$discp_c],4,2)));
		//$e_labl->outlinecolor->setRGB(0,0,255);
		//$e_labl->backgroundcolor->setRGB(255,255,255);
		//$e_labl->backgroundshadowcolor->setRGB(255,255,255);
		
//		echo $e_labl->color;
	} // fin si echelle assez grande pour afficher contours noirs

	// autre couche utilis?e pour l'int?rieur de la ligne, dont la couleur varie suivant la discipline	
	$e_lay2 = ms_newLayerObj($e_map);
	$e_lay2->set('name','parcourslineover');
	$e_lay2->set('status',MS_ON);
	$e_lay2->set('connectiontype',MS_POSTGIS);
	$e_lay2->set('connection',$db->connstr);
	$query = "parcours_geom from parcours";
	if ($where_parc!="")	$e_lay2->setFilter($where_parc);
	$e_lay2->set('data',$query);
	$e_lay2->set('type',MS_LAYER_LINE);
	$e_lay2->set('classitem','parcours_discp');

	// boucle inutile car 	on n'affiche qu'une discipline ? la fois, on le laisse au cas o?
	for ($i_disc=1;$i_disc<=count($discps);$i_disc++) {
		$e_cla2[$i_disc] = ms_newClassObj($e_lay2);
		$e_cla2[$i_disc]->setExpression($i_disc);
		$e_sty2[$i_disc] = ms_newStyleObj($e_cla2[$i_disc]);
		$e_sty2[$i_disc]->set("symbolname","circle");
		$e_sty2[$i_disc]->set("size",$intparcwdth);
		$e_sty2[$i_disc]->color->setRGB(hexdec(substr($discpcolor[$i_disc],0,2)),hexdec(substr($discpcolor[$i_disc],2,2)),hexdec(substr($discpcolor[$i_disc],4,2)));	
	} // fin boucle sur discp

	 
// affichage des pictos, sur le point de d?part du parcours
	if ($e_map->scale < $minscaledispictos ) {
		// couches de labels/pictos avec des couleurs diff?rentes suivant les types
		$e_lay = ms_newLayerObj($e_map);
		$e_lay->set('name','parcours');
		$e_lay->set('status',MS_ON);
		$e_lay->set('labelcache',MS_ON); // par d?faut
	
		$e_lay->set('connectiontype',MS_POSTGIS);
		$e_lay->set('connection',$db->connstr);
		$query = "parcours_start from parcours";
		if ($where_parc!="")	$e_lay->setFilter($where_parc);
		$e_lay->set('data',$query);
		$e_lay->set('type',MS_LAYER_POINT);
		$e_lay->set('labelitem','parcours_id');
		$e_lay->set('classitem','parcours_discp');
		
		for ($i_disc=1;$i_disc<=count($discps);$i_disc++) {
			$e_cla3[$i_disc] = ms_newClassObj($e_lay);
			$e_cla3[$i_disc]->set('name',$name[$i_disc]);
			$e_cla3[$i_disc]->setExpression($i_disc);
			$e_sty3[$i_disc] = ms_newStyleObj($e_cla3[$i_disc]);
			// affichagage des labels slt en dessous d'une certaine ?chelle
			if (isset($e_map->scale) &&  $e_map->scale < $minscaledisplabels && $e_map->scale!=-1) {
				$e_lab[$i_disc] = $e_cla3[$i_disc]->label;
				$e_lab[$i_disc]->set("position",MS_AUTO);
				$e_lab[$i_disc]->backgroundshadowcolor->setRGB(200,200,200);
	
				$e_lab[$i_disc]->set("size",$parclabelsize);
				$e_lab[$i_disc]->set("type","truetype");
				$e_lab[$i_disc]->set("font",$parclabelfont);
				$e_lab[$i_disc]->color->setRGB(0,0,0);
				$e_lab[$i_disc]->backgroundcolor->setRGB(hexdec(substr($discpcolor[$i_disc],0,2)),hexdec(substr($discpcolor[$i_disc],2,2)),hexdec(substr($discpcolor[$i_disc],4,2)));
			} // fin si echelle assez grande pour afficher les labels
			$e_sty3[$i_disc]->set("symbolname",$name[$i_disc]);
		} // fin boucle sur les types de parcours
	} // fin si echelle suffisante pour afficher les pictos..
} // fin si il y des parcours ? afficher

// couches de labels/pictos des objets LEI
$where_lei_f="";
	$where_lei_f='';
	foreach ($_REQUEST as $cle=>$val) { // passe en revue tte les var get
		// la clÃ© est de la forme "c3kGnnnnnnnCnnnnnnnnTnnnnnnnn"
		if (substr($cle,0,3)=="c3k" && $val!="" && strstr($cle,"T")) {
			$where_lei_f.= " lei_f_idcat=".substr(strrchr($cle,"T"),1)." OR ";
		}
	}
	if ($where_lei_f!='') $where_lei_f=vdc($where_lei_f,4); // enleve les 4 derniers car cad le dernier " OR "

//print_r($where_lei_f);

if ($bool_disp_lay_LEI && $where_lei_f!="") {
	$lei_lay = ms_newLayerObj($e_map);
	$lei_lay->set('name','lei_fiche');
	$lei_lay->set('status',MS_ON);
	$lei_lay->set('labelcache',MS_ON); // par d?faut

	$lei_lay->set('connectiontype',MS_POSTGIS);
	$lei_lay->set('connection',$db->connstr);
	$query = "lei_f_pos from lei_fiches";
	if ($where_lei_f!="")	$lei_lay->setFilter($where_lei_f);
	$lei_lay->set('data',$query);
	$lei_lay->set('type',MS_LAYER_POINT);
	$lei_lay->set('labelitem','lei_f_libelle');
	$lei_lay->set('classitem','lei_f_idcat');
	
	$i=i;	
	// faudrait fair eune boucle sur les categ de pts pour avoir des pictos diffÃ©rents..
	//foreach ($tb_lei_selidcat as $idcat) {
		$lei_cla[$i] = ms_newClassObj($lei_lay);
		$lei_cla[$i]->setExpression($idcat);
		$lei_sty[$i] = ms_newStyleObj($lei_cla[$i]);
		$lei_sty[$i]->set("symbolname","tux_L");
		
		//$lei_sty[$i]->set("symbolname",RecupLib("lei_categ","lei_cat_id", "lei_cat_symb", $idcat));
		
		$lei_stylab[$i] = ms_newStyleObj($lei_cla[$i]);
		if (isset($e_map->scale) &&  $e_map->scale < $minscaledisp_leilabs && $e_map->scale!=-1) {
			$lei_lab[$i] = $lei_cla[$i]->label;
			$lei_lab[$i]->set("position",MS_AUTO);
			//$lei_lab[$i_disc]->backgroundshadowcolor->setRGB(200,200,200);
	
			$lei_lab[$i]->set("size",$leilabelsize);
			$lei_lab[$i]->set("type","truetype");
			$lei_lab[$i]->set("font",$leilabelfont);
			$lei_lab[$i]->color->setRGB(222,16,23);
			$lei_lab[$i]->backgroundcolor->setRGB(4,130,50);
		}
		$i++;
			
	//} // fin boucle sur les categ
	
	
	$lei_clalab = ms_newClassObj($lei_lay);
	$lei_stylab = ms_newStyleObj($lei_clalab);
	if (isset($e_map->scale) &&  $e_map->scale < $minscaledisplabels && $e_map->scale!=-1) {
		$i_disc=1;
		$lei_lab[$i_disc] = $lei_clalab->label;
		$lei_lab[$i_disc]->set("position",MS_AUTO);
		//$lei_lab[$i_disc]->backgroundshadowcolor->setRGB(200,200,200);

		$lei_lab[$i_disc]->set("size",$leilabelsize);
		$lei_lab[$i_disc]->set("type","truetype");
		$lei_lab[$i_disc]->set("font",$leilabelfont);
		$lei_lab[$i_disc]->color->setRGB(255,0,0);
		$lei_lab[$i_disc]->backgroundcolor->setRGB(200,200,200);
	} // fin si echelle assez grande pour afficher les labels LEI */
}

// trace dessin?e en temps r?el en ligne
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

// affichage l?gende
if ($e_map->scale < $minscaledispscan100legend) $smarty->assign('booldisplegscan100',true);
// outil zoom + s?l?ectionn? par d?faut au dela d'une certaine ?chelle
if ($e_map->scale > $minscaledispzoomp) $focus['zoomin'] = "focus";

// reconstitue la l?gende avec les pictos
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


// idem pour les pictos LEI: calcul des coords pour l'image pap
if ($where_lei_f!="") {
	$ppmplei = $db->get_lei_pts(array($extminx,$extminy,$extmaxx,$extmaxy,$where_lei_f));
	for ($i=0;$i<count($ppmplei);$i++) {
		if (preg_match("/POINT\(([\.0-9]*) ([\.0-9]*)\)/",$ppmplei[$i]['coord'],$m)) {
			$xx = geo2pix($m[1],$extminx,$extmaxx,$sizex);
			$yy = geo2pix($m[2],$extmaxy,$extminy,$sizey);
			$ppmplei[$i]['rect'] = ($xx - $xd2pp) .','. ($yy - $yd2pp) .','. ($xx + $xd2pp) .','. ($yy + $yd2pp);
		}
	}
	$smarty->assign('ppmplei',$ppmplei);
	$smarty->assign('lei_f_url',$lei_f_url);// Assigne l'url  ? rallonge du skel (cf conf.php), ou un exemple statique
}
//debug("ppmplei");

/* ANCIENNE METHODE SELECT LEI AVEC LISTE DEROULANTE A CHOIX MULTIPLES
fait maintenant par ret_tb_cat_lei()
// nouvel objet pour s?lection liste d?roulante points LEI
$ObjSeLEI=new PYAobj();
$ObjSeLEI->NmBase=$dbname;
$ObjSeLEI->NmTable="lei_fiches";
$ObjSeLEI->NmChamp="lei_f_idcat";
$ObjSeLEI->InitPO();
$tabLD=ttChpLink($ObjSeLEI->Valeurs);

if (is_array($_REQUEST['rq_lei_f_idcat'])) { // s'il y des valeurs s?lectionn?es
// recherche des valeurs pr?c?demment selectionnn?e pour les remettre en s?lection
	foreach($tabLD as $k=>$v) {
		if (in_array($k,$_REQUEST['rq_lei_f_idcat'])) $tabLD[$k]=$VSLD.$v;
	}
}
//$tabLD=array(0=>"Aucun")+$tabLD;
$DispMsg=false; // n'affiche pas la mention en bas de la liste d?roulante
*/

//$smarty->assign('LD_filt_pts_LEI',DispLD($tabLD,"rq_lei_f_idcat","yes","",false));

// nbre max de traces affich?es dans la liste
$maxdisptracks=($_SESSION['admin'] ? 100 : 20);
$smarty->assign('maxdisptracks',$maxdisptracks);

$smarty->assign('sizex',$sizex);
$smarty->assign('pid',$_SESSION['pid']);
$smarty->assign('sizey',$sizey);
$smarty->assign('sizecheck',$sizecheck);
$smarty->assign('mapmargin',$mapmargin);
$smarty->assign('blockspc',$blockspc);
$scale = $e_map->scale;
$smarty->assign('scale',floor($scale));
$smarty->assign('refsrc',$refsrc);
$smarty->assign('refwidth',$refwidth);
$smarty->assign('refheight',$refheight);
$smarty->assign('focus',$focus);
if (isset($map_click)) $smarty->assign('map_click',$map_click);
$smarty->assign('mapimage',$image);
$smarty->assign('discps',$discps);
$smarty->assign('discpcolor',$discpcolor);
//$smarty->assign('icontypes',$icontypes);
$smarty->assign('times',$times);
$smarty->assign('levels',$levels);

$smarty->display("map.tpl");
echo "<div style='font-size:9px;padding:3px;'>". tra('Temps').' : '. elapsed_time()." s</div>";

?>
