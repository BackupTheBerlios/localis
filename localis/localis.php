<? /* $Id: localis.php,v 1.26 2002/10/24 22:06:04 mose Exp $
Copyright (C) 2002, Makina Corpus, http://makina-corpus.org
This file is a component of Localis <http://localis.makina-corpus.org>
Created by mose@makina-corpus.org and mastre@makina-corpus.org
Maintained by Makina Corpus <localis@makina-corpus.org>

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307,
USA.
*/
$click_x = $HTTP_GET_VARS['x'];
$click_y = $HTTP_GET_VARS['y'];
$refx    = ($HTTP_GET_VARS['ref_x']) ? $HTTP_GET_VARS['ref_x'] : $HTTP_GET_VARS['ref.x'];
$refy    = ($HTTP_GET_VARS['ref_y']) ? $HTTP_GET_VARS['ref_y'] : $HTTP_GET_VARS['ref.y'];
$scl     = ($HTTP_GET_VARS['forcescale']) ? $HTTP_GET_VARS['forcescale'] : $HTTP_GET_VARS['scale'];
$lay     = ($HTTP_GET_VARS['layers']) ? $HTTP_GET_VARS['layers'] : array("fond");
$act     = ($HTTP_GET_VARS['action']) ? $HTTP_GET_VARS['action'] : 'travel';
$size    = ($HTTP_GET_VARS['size']) ? $HTTP_GET_VARS['size'] : "400x400";
$type    = ($HTTP_GET_VARS['type']) ? $HTTP_GET_VARS['type'] : "";
$city    = $HTTP_GET_VARS['v'];
if ($HTTP_GET_VARS['forceextent.x'] or $HTTP_GET_VARS['forceextent_x']) {
	$ext     = split(' ',trim($HTTP_GET_VARS['forceextent']));
} else {
	$ext     = split(' ',trim($HTTP_GET_VARS['extent']));
}
$view    = $HTTP_GET_VARS['tpl'];
$addcity = $HTTP_GET_VARS['add_city'];
$addtype = $HTTP_GET_VARS['add_type'];
$addnom = $HTTP_GET_VARS['add_nom'];
$addemail = $HTTP_GET_VARS['add_email'];
$addurl = $HTTP_GET_VARS['add_url'];
$addnotes = $HTTP_GET_VARS['add_notes'];
$addit   = $HTTP_GET_VARS['addit'];

if (strstr($HTTP_GET_VARS['size'],'x')) {
	list($sizex,$sizey) = split('x',$HTTP_GET_VARS['size']);
	if ($sizex > 1200) $sizex = '1200';
	if ($sizey > 1200) $sizey = '1200';
}
dl('php_mapscript.so');
include "inc/parseconf.php";
include "inc/lib.php";

$version = current(file('VERSION'));

# Read configuration file and set array like $conf[section][item]
if (!is_file('etc/localis.conf')) die("etc/localis.conf not found<br>You need to copy etc/localis.conf.dist and modify it to fit your needs.");
$conf = parseconf('etc/localis.conf');
$conn = sig_connect();
# Fetch information from mysql and create menu items and select option.
# Debugged to preserve selections and adapted to new conf file.
foreach ($conf[form] as $field=>$f) {
	${"$field"}    = $HTTP_GET_VARS["$field"];
	${"list_$field"} = sig_list($f,$conn,0);
	${"menu_$field"} = domenu(${"list_$field"},$$field);
	# If search string, build 'where' clause.
	if (!empty(${"$field"}) and ereg("^text://.*$",$conf[form][$field])) {
		$myv = str_replace('/','',strrchr($conf[form][$field],'/'));
			$mm = explode(',',$myv);
			foreach($mm as $mmv) {
			$owh[] = "$mmv like '%".${"$field"}."%'";
			$eff[] = sprintf($conf["general"]["search_listresult"], ucfirst($field));
		}
	}
} 

if ($addit and $addcity and ($addtype != 'all')) {
	additem($addtype,$addcity,$addnom,$addemail,$addurl,$addnotes);
}
	
if (!is_file($conf["map"]['path']."/fonts/fontset")) {
	$dir = opendir($conf["map"]["path"]."/fonts");
	if ($dir) {
		while (false !== ($dd = readdir($dir))) {
			if ($dd and (substr($dd,0,1) != '.') and (substr($dd,-4,4) == '.ttf')) {
				$fonts.= strtolower(substr(basename($dd),0,-4))."    ".$conf["map"]["path"]."/fonts/".$dd."\n";
			}
		}
	}
	echo $fonts;
	closedir($dir);
	$fp = fopen($conf["map"]['path']."/fonts/fontset","w+");
	fputs($fp,$fonts);
	fclose($fp);
}

# Select layer to use
if ($$field == 'all') {
	array_shift($listres);
	$mychoices = $listres ;
	$type = '';
} else {
	$mychoices[] = $$field;
}

# Build layer selection (left menu)
$js_start = 9; # erk !! I have to fix that hard coded value
foreach($conf[layers] as $def_layer=>$res_layer) {
	$lol += 1;
	unset($lys);
	$lys[] = $def_layer;
	foreach ($lys as $l) {
		if (@in_array(trim($l),$lay)) {
			$layer_menu.= "<tr><td class=toolchecked onclick='document.f.elements[".($lol+$js_start)."].checked=!document.f.elements[".($lol+$js_start)."].checked;'>";
			$layer_menu.= "<input type=checkbox name=layers[] value='$l' checked onclick='this.checked=!this.checked;'> ".$conf["gui"]["$l"]."</td></tr>\n";
			$layer_hidden.= "<input type=hidden name=layers[] value='$l'>\n";
			$layer_query.= "layers[]=".urlencode($l)."&";
		} else {
			$layer_menu.= "<tr><td class=toolch onclick='document.f.elements[".($lol+$js_start)."].checked=!document.f.elements[".($lol+$js_start)."].checked;'>";
			$layer_menu.= "<input type=checkbox name=layers[] value='$l' onclick='this.checked=!this.checked;'>".$conf["gui"]["$l"]."</td></tr>\n";
		}
	}
}

# Set layer status (on/off) [patché et debuggué choppe seul le nom des layers]
if ($view != $conf[gui][list_button]) {
	$zMap = ms_newMapObj($conf["map"]["path"].'/'.$conf["map"]["file"]);
	$zWeb = $zMap->web;
	$zWeb->set('imagepath',$conf["general"]["tmp_path"]."/");
	$lys = array();
	$lys = $zMap->getAllGroupNames();
	foreach ($lys as $l) {
		$tl = array();
		$tl = $zMap->getLayersIndexByGroup($l);
		if ((is_array($tl)) and (!in_array($l,$lay))) {
			foreach ($tl as $t) {
				$zLayer = $zMap->getLayer($t);
				$zLayer->set("status",MS_OFF);
			}
		}
	}	
	$zLimit = ms_newRectObj();
	$zLimit->setextent($conf[map][ext_minx],$conf[map][ext_miny],$conf[map][ext_maxx],$conf[map][ext_maxy]);
	// had to hack to make min = 0 acceptable proposition
	$maxext = (string) (int) $conf[map][ext_minx].' '.(string) (int) $conf[map][ext_miny].' '.$conf[map][ext_maxx].' '.$conf[map][ext_maxy];
	if (!$sizex) {
		$zSizex = $zMap->width;
		$zSizey = $zMap->height;
		$sizex = $zSizex;
		$sizey = $zSizey;
	} else {
		$zSizex = $sizex;
		$zSizey = $sizey;
	}
	if (!is_array($ext)) {
		$zExtent = $zMap->extent;
	} else {
		$zExtent = ms_newRectObj();
		$zExtent->setextent($ext[0],$ext[1],$ext[2],$ext[3]);
	}
	
	$zClick = ms_newPointObj();
	if ($act and ($refx and $refy) and (sizeof($ext) > 3)) {
		$zClick->setXY($refx,$refy,0);
		$zMap->set("width",$sizex);
		$zMap->set("height",$sizey);
		$zMap->zoomscale($scl*1000,$zClick,142,142,$zLimit,$zLimit);
	} elseif ($city) {
		$refx = geo2pix($click_x,$conf[map][ext_minx],$conf[map][ext_maxx],$sizex);
		$refy = $sizey - geo2pix($click_y,$conf[map][ext_miny],$conf[map][ext_maxy],$sizey);
		$zClick->setXY($refx,$refy,0);
		$zMap->set("width",$sizex);
		$zMap->set("height",$sizey);
		$zMap->zoomscale($scl*1000,$zClick,$sizex,$sizey,$zLimit,$zLimit);
	} else {
		if (($act != "edition") and $click_x and $click_y) {
			$zClick->setXY($click_x,$click_y,0);
			$sizemapx = $sizex;
			$sizemapy = $sizey;
			$extmap = $zExtent;
			$clicked = TRUE;
		} else {
			$zClick->setXY(floor($sizex/2),floor($sizey/2),0);
			$sizemapx = $sizex;
			$sizemapy = $sizey;
			$extmap = $zExtent;
			$clicked = FALSE;
		}
		if ($clicked and ($act == "zoomin")) {
			$zMap->zoompoint(2,$zClick,$sizemapx,$sizemapy,$extmap,$zLimit);
		} elseif ($clicked and ($act == "zoomout")) {
			$zMap->zoompoint(-2,$zClick,$sizemapx,$sizemapy,$extmap,$zLimit);		
		} elseif ($act == "edition") {
			$zMap->zoompoint(1,$zClick,$sizemapx,$sizemapy,$extmap,$zLimit);		
			$coordx = pix2geo($click_x,$ext[0],$ext[2],$sizex) + $ext[0];
			$coordy = $ext[3] - pix2geo($click_y,$ext[1],$ext[3],$sizey);
			$flagid = dbf_flag($click_x, $click_y, $coordx, $coordy);
			$addville = domenu(surrounding($coordx,$coordy,10000),'');
		} elseif ($clicked and ($act == "travel")) {
			$zMap->zoompoint(1,$zClick,$sizemapx,$sizemapy,$extmap,$zLimit);
		} elseif ($scl and $zClick) {
			$zMap->zoompoint(1,$zClick,$sizemapx,$sizemapy,$extmap,$zLimit);
			$act = "travel";
		}
	}
	$zMap->set("width",$sizex);
	$zMap->set("height",$sizey);
	$zImage    = $zMap->draw();
	$zExtent   = $zMap->extent;
	$ext = ext2array($zExtent);
	$extexploded = implode(' ',$ext);
	# create result layer
	if (count($ext) > 3) {
		$wh[] = "((".$conf[general][sql_reftable].".".$conf[map][coord_x].") between $ext[0] and $ext[2])";
		$wh[] = "((".$conf[general][sql_reftable].".".$conf[map][coord_y].") between $ext[1] and $ext[3])";
	}
	foreach($mychoices as $myc) {
		if (!empty($myc)) {
			$eff[] = sprintf($conf["general"]["search_listresult"], ucfirst($myc));
			prepare_list($wh,$conn,$myc,$owh);
			$id = dbf_gen($conf[database][db_name],$conf[general][sql_reftable],$resultats,$wh,$conn,$owh);
			$list .= build_list($found,$qu,$eff);
			unset($found);
			unset($nbres);
			unset($nbresresultats);
			unset($resultats);
			$mylayer = str_replace('/','',strrchr($conf[infos][$myc],'/'));
			$zResult = $zMap->getLayerByName($mylayer);
			$zResult->set('status',MS_ON);
			$zResult->set('data',$conf[general][tmp_path]."/$id");
			$zResult->draw($zImage);
			if (!is_file($conf[general][tmp_path]."/$id.shp")) echo "$id.shp not found<br>";
			if (!is_file($conf[general][tmp_path]."/$id.shx")) echo "$id.shx not found<br>";
			if (!is_file($conf[general][tmp_path]."/$id.dbf")) echo "$id.dbf not found<br>";
			# Place javascript info area on points
			if (is_array($m)) {
				foreach ($m as $vv=>$coord) {
					$map_txt = preg_replace("/\r?\n/","<br>",addslashes($maplist[$vv]));
					$map_locations.= "<area href=\"#top\" name=\"$vv\" shape=\"rect\" coords=\"".($coord[x]-10).",".($coord[y]-10).",".($coord[x]+10).",".($coord[y]+10)."\" ";
					$map_locations.= "onmouseover=\"return overlib('<b style=font-size:120%>".addslashes($vv)."</b><br>$map_txt', WIDTH, 150);\" ";
					$map_locations.= " onmouseout='return nd();' onclick=\"return overlib('$map_txt', STICKY, CLOSECLICK, CAPTION, '&nbsp;".addslashes($vv)."', WIDTH, 150);\">\n";
				}
			}
		}
	}
	if ($flagid) {
		$zResult = $zMap->getLayerByName('flag');
		$zResult->set('status',MS_ON);
		$zResult->set('data',$conf[general][tmp_path]."/$flagid");
		$zResult->draw($zImage);
	}
	# Create image, reference map & legend
	$image_src = $zImage->saveWebImage(MS_PNG,0,0,-1);
	$zRefer    = $zMap->reference;
	$zRefer->set('width',$conf[map][ref_sizex]);
	$zRefer->set('height',$conf[map][ref_sizey]);
	$zRef      = $zMap->drawreferencemap();
	$ref_src   = $zRef->saveWebImage(MS_PNG,0,0,-1);
	$zLegende  = $zMap->drawLegend();
	$leg_src   = $zLegende->saveWebImage(MS_PNG,0,0,-1);
	$scl = number_format($zMap->scale,0,',',' ');
} else {
	# Prepare list view
	$extexploded = implode(' ',$ext);
	if (count($ext) > 3) {
		$wh[] = "((".$conf[general][sql_reftable].".".$conf[map][coord_x].") between $ext[0] and $ext[2])";
		$wh[] = "((".$conf[general][sql_reftable].".".$conf[map][coord_y].") between $ext[1] and $ext[3])";
	}
	$qu[] = "tpl=$tpl";
	if (is_array($lay)) {
		foreach ($lay as $l) {
			$qu[] = "layers[]=$l";
		} 
	}
	$qu[] = "extent=".urlencode($extexploded);
	foreach($mychoices as $myc) {
		$eff[] = sprintf($conf["general"]["search_listresult"], ucfirst($myc));
		prepare_list($wh,$conn,$myc,$owh);
		$list .= build_list($found,$qu,$eff);
	}
}
${"action_$act"} = "checked";
${"size_".$sizex."x".$sizey}   = "selected";


# Place javascript info area on points
if (is_array($m)) {
	foreach ($m as $vv=>$coord) {
		$map_txt = preg_replace("/\r?\n/","<br>",addslashes($maplist[$vv]));
		$map_locations.= "<area href=\"#top\" name=\"$vv\" shape=\"rect\" coords=\"".($coord[x]-10).",".($coord[y]-10).",".($coord[x]+10).",".($coord[y]+10)."\" ";
		$map_locations.= "onmouseover=\"return overlib('<b style=font-size:120%>".addslashes($vv)."</b><br>$map_txt', WIDTH, 150);\" ";
		$map_locations.= "onmouseout='return nd();' onclick=\"return overlib('$map_txt', STICKY, CLOSECLICK, CAPTION, '&nbsp;".addslashes($vv)."', WIDTH, 150);\">\n";
	}
}
mysql_close($conn);

$colwidth = $conf[map][ref_sizex]+4;

echo inc("head");
echo inc("search");
if ($view == $conf[gui][list_button]) {
	echo inc("list");
} else {
	if ($act == "edition") {
		$edit = inc("edit");
	}
	echo inc("map");
}
echo inc("foot");

if ($id)  tmpclean($id);
if ($sid) tmpclean($sid);
if (0 or $conf[gui][debug]) { echo "<pre style=font-size:80%;color:#990000>";print_r(get_defined_vars());echo "</pre>"; }
?>
