<? /* $Id: localis.php,v 1.46 2003/02/03 08:28:44 mose Exp $
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

dl('php_mapscript.so');
include "inc/parseconf.php";
include "inc/lib.php";
$glob['version'] = current(file('VERSION'));

$click_x = $HTTP_GET_VARS['x'];
$click_y = $HTTP_GET_VARS['y'];
$refx    = ($HTTP_GET_VARS['ref_x']) ? $HTTP_GET_VARS['ref_x'] : $HTTP_GET_VARS['ref.x'];
$refy    = ($HTTP_GET_VARS['ref_y']) ? $HTTP_GET_VARS['ref_y'] : $HTTP_GET_VARS['ref.y'];
$scl     = ($HTTP_GET_VARS['forcescale']) ? $HTTP_GET_VARS['forcescale'] : $HTTP_GET_VARS['scale'];
$lay     = ($HTTP_GET_VARS['layers']) ? $HTTP_GET_VARS['layers'] : array("fond");
$act     = ($HTTP_GET_VARS['action']) ? $HTTP_GET_VARS['action'] : 'travel';
$drawlayer    = $HTTP_GET_VARS['drawlayer'];
$city    = $HTTP_GET_VARS['v'];
$view    = $HTTP_GET_VARS['tpl'];
$addnom = $HTTP_GET_VARS['addnom'];
$addlat = $HTTP_GET_VARS['addlat'];
$addlong = $HTTP_GET_VARS['addlong'];
$addstatut = $HTTP_GET_VARS['addstatut'];
$addemail = $HTTP_GET_VARS['addemail'];
$adddesc = $HTTP_GET_VARS['adddesc'];
$addit   = $HTTP_GET_VARS['addit'];
$fzoom   = $HTTP_GET_VARS['fzoom'];
$fzoomout   = $HTTP_GET_VARS['fzoomout'];
$fsens   = $HTTP_GET_VARS['fsens'];
// ROU check if user agent is IE
$mode = ereg("MSIE",getenv("HTTP_USER_AGENT")) ? "ie" : "";
// ROU handle map interface type value (map or point)
$interface  = ($HTTP_GET_VARS['interface']) ? $HTTP_GET_VARS['interface'] : 'mapImg';
// ROU was here

if (strstr($HTTP_GET_VARS['size'],'x')) {
	list($sizex,$sizey) = split('x',$HTTP_GET_VARS['size']);
	if ($sizex > 1200) $sizex = '1200';
	if ($sizey > 1200) $sizey = '1200';
}
# Read configuration file and set array like $conf[section][item]
if (!is_file('etc/localis.conf')) die("etc/localis.conf not found<br>You need to copy etc/localis.conf.dist and modify it to fit your needs.");
$conf = parseconf('etc/localis.conf');

$lang = ($HTTP_GET_VARS['lang']) ? $HTTP_GET_VARS['lang'] : $conf['general']['lang'];
$mode = ($HTTP_GET_VARS['mode']) ? $HTTP_GET_VARS['mode'] : $conf['general']['mode'];

if ($HTTP_GET_VARS['lang']) {
  $glob['query'].= "&lang=$lang";
	$glob['input'].= "<input type=\"hidden\" name=\"lang\" value=\"$lang\">";
}
if ($HTTP_GET_VARS['mode']) {
  $glob['query'].= "&mode=$mode";
	$glob['input'].= "<input type=\"hidden\" name=\"mode\" value=\"$mode\">";
}	

$tpl_path = $conf[general][tpl_path]."/$mode";

if (is_file("$tpl_path/$lang/globals.php")) {
  include "$tpl_path/$lang/globals.php";
}

if ($HTTP_GET_VARS['forceextent.x'] or $HTTP_GET_VARS['forceextent_x']) {
	$ext = array($conf[map][ext_minx],$conf[map][ext_miny],$conf[map][ext_maxx],$conf[map][ext_maxy]);
} elseif ($HTTP_GET_VARS['extent']) {
	$ext = split(' ',trim($HTTP_GET_VARS['extent']));
} else {
	$ext = array($conf[map][ext_minx],$conf[map][ext_miny],$conf[map][ext_maxx],$conf[map][ext_maxy]);
}

$size    = ($HTTP_GET_VARS['size']) ? $HTTP_GET_VARS['size'] : $conf[gui]['defaultmapsize'];

$conn = sig_connect();

if ($addit and ($addtype != 'all')) {
	additem($addnom,$addemail,$adddesc,$addstatut,$addlat,$addlong);
}

$userlayers = layerslist();


if (!is_file($conf["map"]['path']."/fonts/fontset")) {
	$dir = opendir($conf["map"]["path"]."/fonts");
	if ($dir) {
		while (false !== ($dd = readdir($dir))) {
			if ($dd and (substr($dd,0,1) != '.') and (substr($dd,-4,4) == '.ttf')) {
				$fonts.= strtolower(substr(basename($dd),0,-4))."    ".$conf["map"]["path"]."/fonts/".$dd."\n";
			}
		}
	}
	closedir($dir);
	$fp = fopen($conf["map"]['path']."/fonts/fontset","w+");
	fputs($fp,$fonts);
	fclose($fp);
}

$mychoices = array("points");


# Set layer status (on/off) [patché et debuggué choppe seul le nom des layers]
$zMap = ms_newMapObj($conf["map"]["path"].'/'.$conf["map"]["file"]);
list($sizex,$sizey) = split('x',$size);
$zMap->set('width', $sizex);
$zMap->set('height', $sizey);
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
} elseif (!empty($fsens)) {
	$fExt = move_map($ext,$fsens);
	$zExtent = ms_newRectObj();
	$zExtent->setextent($fExt[0],$fExt[1],$fExt[2],$fExt[3]);
} else {
	$zExtent = ms_newRectObj();
	$zExtent->setextent($ext[0],$ext[1],$ext[2],$ext[3]);
}

$zClick = ms_newPointObj();
if ($act and ($refx and $refy) and (sizeof($ext) > 3)) {
	$refx = floor($refx*($sizex/$conf[map][ref_sizex]));
	$refy = floor($refy*($sizey/$conf[map][ref_sizey]));
	$zClick->setXY($refx,$refy,0);
	$zMap->set("width",$sizex);
	$zMap->set("height",$sizey);
	#$zMap->zoomscale($scl*1000,$zClick,142,142,$zLimit,$zLimit);
	$zMap->zoomscale($scl*1000,$zClick,$sizex,$sizey,$zLimit,$zLimit);
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
	if (!empty($fzoom)) {
		$zMap->zoompoint(2,$zClick,$sizemapx,$sizemapy,$extmap,$zLimit);
	}
	if (!empty($fzoomout)) {
		$zMap->zoompoint(-2,$zClick,$sizemapx,$sizemapy,$extmap,$zLimit);
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
	} elseif ($scl and $zClick and empty($fzoom) and empty($fzoomout)) {
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
		if (is_array($found)) {
			$list .= build_list($found,$qu,$eff);
		}
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
		if ($act != 'edition') {
			if (is_array($m)) {
				foreach ($m as $vv=>$coord) {
					$map_txt = preg_replace("/\r?\n/","<br>",addslashes(str_replace('"',"'",$maplist[$vv])));
					$map_locations.= "<area href=# name=\"$vv\" id=\"$vv\" shape=\"rect\" coords=\"".($coord[x]-10).",".($coord[y]-10).",".($coord[x]+10).",".($coord[y]+10)."\" \n";
					$map_locations.= "onmouseover=\"return overlib('<b style=font-size:120%>".addslashes($vv)."</b><br>$map_txt', WIDTH, 150);\" \n";
					$map_locations.= "onmouseout='return nd();' onclick=\"return overlib('$map_txt', STICKY, CLOSECLICK, CAPTION, '&nbsp;".addslashes($vv)."', WIDTH, 150);\">\n";
				}
			}
		}
	}
}
if ($drawlayer) {
	lcls_drawlayer($drawlayer);
}
if ($flagid) {
	$zResult = $zMap->getLayerByName('flag');
	$zResult->set('status',MS_ON);
	$zResult->set('data',$conf[general][tmp_path]."/$flagid");
	$zResult->draw($zImage);
	$map_txt = "Vous êtes ici.";
	$vv = 'flag';
	$map_locations.= "<area href=# name=\"$vv\" id=\"$vv\" shape=\"rect\" coords=\"".($click_x-10).",".($click_y-10).",".($click_x+10).",".($click_y+10)."\" \n";
	$map_locations.= "onmouseover=\"return overlib('$map_txt');\" onmouseout='return nd();'>\n";
}
# Create image, reference map & legend
$glob[imgsrc] = $zImage->saveWebImage(MS_PNG,0,0,-1);
$zRefer    = $zMap->reference;
$zRefer->set('width',$conf[map][ref_sizex]);
$zRefer->set('height',$conf[map][ref_sizey]);
$zRef      = $zMap->drawreferencemap();
$glob[refsrc]   = $zRef->saveWebImage(MS_PNG,0,0,-1);
$zLegende  = $zMap->drawLegend();
$glob[legsrc]   = $zLegende->saveWebImage(MS_PNG,0,0,-1);
$scl = number_format($zMap->scale,0,',',' ');
# Build layer selection (left menu)
# thanks raz for cleaning !!
foreach($conf[layers] as $l=>$lv) {
	if (@in_array(trim($l),$lay)) {
		$glob['layermenu'].= "<tr><td class=\"toolchecked\" onclick=\"document.f.$l.checked=!document.f.$l.checked;\">";
		$glob['layermenu'].= "<input type=\"checkbox\" id=\"$l\" name=\"layers[]\" value=\"$l\" checked onclick=\"this.checked=!this.checked;\"> $lv</td></tr>\n";
		#$glob['input'].= "<input type=\"hidden\" name=\"layers[]\" value=\"$l\">\n";
		#$glob['query'].= "&layers[]=".urlencode($l);
	} else {
		$glob['layermenu'].= "<tr><td class=toolch onclick='document.f.$l.checked=!document.f.$l.checked;'>";
		$glob['layermenu'].= "<input type=checkbox id=\"$l\" name=layers[] value='$l' onclick='this.checked=!this.checked;'> $lv</td></tr>\n";
	}
}
if (is_array($userlayers)) {
  foreach ($userlayers as $ulnum=>$ul) {
    if ($drawlayer == $ulnum) {
			$glob['query'].= "&ulayers[]=$ulnum";
			$glob['input'].= "<input type=\"hidden\" name=\"drawlayer\" value=\"$ulnum\">\n";
      $glob['catmenu'].= "<option value=$ulnum selected style=background-color:#FFCC99>$ul[layername]</option>";
    } else {
      $glob['catmenu'].= "<option value=$ulnum>$ul[layername]</option>";
    }
  }
} 

// ROU used by ie map
${"check$interface"} = "checked";
// ROU was here
#${"action_$act"} = "checked";
#${"size_".$sizex."x".$sizey}   = "selected";
$glob["lang$lang"] = "selected";
$glob["act".$act] = "checked";
$glob["size".$sizex."x".$sizey] = "selected";
$glob['sizex'] = $sizex;
$glob['sizey'] = $sizey;
$glob['scale'] = $scl;

if ($ext) {
	$glob['query'].= "&extent=".urlencode($extexploded);
	$glob['input'].= "<input type=\"hidden\" name=\"extent\" value=\"$extexploded\">";
}
$glob['query'].= "&scale=".urlencode($scl);
$glob['input'].= "<input type=\"hidden\" name=\"scale\" value=\"$scl\">";


mysql_close($conn);

$colwidth = $conf[map][ref_sizex]+4;

echo inc("head");
echo inc("search");
if ($drawlayer == "NEW") {
	$colors["50 120 200"] = "Bleu";
	$colors["255 255 255"] = "Blanc";
	$colors["0 0 0"] = "Noir";
	$colors["50 200 120"] = "Vert";
	$colors["200 120 50"] = "Orange";
	$colors["200 50 0"] = "Rouge";
	$symbols["ordi"] = "Ordi";
	$symbols["flag"] = "Drapeau";
	$ftype_menu = domenu(array('point'=>'point','line'=>'traits'),$ftype);
	$fsize_menu = domenu(array(0,1,2,3,4,5),$fsize);
	$fcolor_menu = domenu($colors,$fcolor);
	$fsymbol_menu = domenu($symbols,$fsymbol);

	$glob['right'] = inc("editlayer");
} elseif ($act == "edition") {
	$glob['right'] = inc("edit");
} else {
	$glob['right'] = $list;
}
echo inc("map");
echo inc("foot");

if ($id)  tmpclean($id);
if($sid) tmpclean($sid);
if (0 or $conf[gui][debug]) { echo "<pre style=font-size:80%;color:#990000>";print_r(get_defined_vars());echo "</pre>"; }
?>
