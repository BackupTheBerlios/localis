<? /* $Id: localis.php,v 1.48 2003/02/04 05:58:15 mose Exp $
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
$city    = $HTTP_GET_VARS['v'];
$view    = $HTTP_GET_VARS['tpl'];
$add     = $HTTP_GET_VARS['add'];
$fzoom   = $HTTP_GET_VARS['fzoom'];
$fzoomout   = $HTTP_GET_VARS['fzoomout'];
$fsens   = $HTTP_GET_VARS['fsens'];
$drawlayer    = $HTTP_GET_VARS['drawlayer'];
$mode = ereg("MSIE",getenv("HTTP_USER_AGENT")) ? "ie" : "";
$interface  = ($HTTP_GET_VARS['interface']) ? $HTTP_GET_VARS['interface'] : 'mapImg';

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

if ($HTTP_GET_VARS['forceextent']) {
	$ext = split(' ',$conf[map][defext]);
} elseif ($HTTP_GET_VARS['extent']) {
	$ext = split(' ',trim($HTTP_GET_VARS['extent']));
} else {
	$ext = split(' ',$conf[map][defext]);
}

list($extminx,$extminy,$extmaxx,$extmaxy) = split(' ',$conf[map][defext]);
$size    = ($HTTP_GET_VARS['size']) ? $HTTP_GET_VARS['size'] : $conf[gui]['defaultmapsize'];

$conn = sig_connect();

checkfontlist($conf["map"]['path']);

/*
if ($addit and ($addtype != 'all')) {
	additem($add[nom],$add[sign],$add[desc],$add[statut],$add[lat],$add[long]);
}
*/

$userlayers = layerslist();

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
$zLimit->setextent($extminx,$extminy,$extmaxx,$extmaxy);
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
		#$flagid = dbf_flag($click_x, $click_y, $coordx, $coordy);
		#$addville = domenu(surrounding($coordx,$coordy,10000),'');
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

if ($drawlayer) {
	$points = lcls_drawlayer($drawlayer);
	if (is_array($points)) {
		$list = "<div class=\"dashed\" style=\"margin-top:15px;padding:15px;\">";
		foreach ($points as $where=>$what) {
			$cdx = strtok($where, '/');
			$cdy = strtok('/');
			$what = preg_replace("/\r?\n/","<br>",addslashes(str_replace('"',"'",$what)));
			$glob[maplocations].= "<area href=\"#\" name=\"$where\" id=\"$where\" shape=\"rect\" coords=\"".($cdx-10).",".($cdy-10).",".($cdx+10).",".($cdy+10)."\" \n";
			$glob[maplocations].= "onmouseover=\"return overlib('".addslashes($what)."', WIDTH, 150);\" \n";
			$glob[maplocations].= "onmouseout='return nd();' onclick=\"return overlib('$what', STICKY, CLOSECLICK, CAPTION, '&nbsp;".addslashes($vv)."', WIDTH, 150);\">\n";
			
			$list.= "<div class=\"list\">$what</div>";
		}
		$list.= "</div>";
	}
}

mysql_close($conn);

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
$glob["lang$lang"] = "selected";
$glob["act".$act] = "checked";
$glob["size".$sizex."x".$sizey] = "selected";
$glob['sizex'] = $sizex;
$glob['sizey'] = $sizey;
$glob['scale'] = $scl;
$glob['coordx'] = $coordx;
$glob['coordy'] = $coordy;

if ($ext) {
	$glob['query'].= "&extent=".urlencode($extexploded);
	$glob['input'].= "<input type=\"hidden\" name=\"extent\" value=\"$extexploded\">";
}
$glob['query'].= "&scale=".urlencode($scl);
$glob['input'].= "<input type=\"hidden\" name=\"scale\" value=\"$scl\">";


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
	$glob['statusmenu'] = domenu(array(0,1,2,3,4,5),0);
	if ($showpoint) {
		
	}
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
