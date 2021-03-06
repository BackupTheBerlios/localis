<? /* $Id: localis.php,v 1.60 2003/03/27 17:16:44 mastre Exp $
Copyright (C) 2003, Makina Source, http://makina-source.org
This file is a component of Localis - http://localis.org
Created by mose <mose@makina-source.org> and mastre <mastre@localis.org>
Maintained by Makina Source <localis@makina-source.org>

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to 
the Free Software Foundation, Inc., 
59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
or check http://www.gnu.org/copyleft/gpl.html
*/

dl('php_mapscript.so');
include "inc/parseconf.php";
include "inc/lib.php";
$glob['version'] = current(file('VERSION'));

$click_x   =  $HTTP_GET_VARS['x'];
$click_y   =  $HTTP_GET_VARS['y'];
$refx      = ($HTTP_GET_VARS['ref_x']) ? $HTTP_GET_VARS['ref_x'] : $HTTP_GET_VARS['ref.x'];
$refy      = ($HTTP_GET_VARS['ref_y']) ? $HTTP_GET_VARS['ref_y'] : $HTTP_GET_VARS['ref.y'];
$scl       = ($HTTP_GET_VARS['forcescale']) ? $HTTP_GET_VARS['forcescale'] : $HTTP_GET_VARS['scale'];
$lay       = ($HTTP_GET_VARS['layers']) ? $HTTP_GET_VARS['layers'] : array("fond");
$act       = ($HTTP_GET_VARS['action']) ? $HTTP_GET_VARS['action'] : 'travel';
$city      =  $HTTP_GET_VARS['v'];
$view      =  $HTTP_GET_VARS['tpl'];
$add       =  $HTTP_GET_VARS['add'];
$showid    =  $HTTP_GET_VARS['showid'];
// for pda template
$fzoom     =  $HTTP_GET_VARS['fzoom'];
$fzoomout  =  $HTTP_GET_VARS['fzoomout'];

$fsens     =  $HTTP_GET_VARS['fsens'];
$editlay   =  $HTTP_GET_VARS['editlay'];
$dellayer  =  $HTTP_GET_VARS['dellayer'];
$confdel   =  $HTTP_GET_VARS['confirmdel'];
$modlayer  =  $HTTP_GET_VARS['modlayer'];
$drawlayer = ($HTTP_GET_VARS['modlayer']) ? $HTTP_GET_VARS['modlayer'] : $HTTP_GET_VARS['drawlayer'];;
$interface = ($HTTP_GET_VARS['interface']) ? $HTTP_GET_VARS['interface'] : 'mapImg';
$mode      = ereg("MSIE",getenv("HTTP_USER_AGENT")) ? "ie" : "";

# Read configuration file and set array : $conf[section][item]
if (!is_file('etc/localis.conf')) die("etc/localis.conf not found<br>You need to copy etc/localis.conf.dist and modify it to fit your needs.");
$conf = parseconf('etc/localis.conf');

$lang = ($HTTP_GET_VARS['lang']) ? (($HTTP_GET_VARS['flang']) ? $HTTP_GET_VARS['flang'] : $HTTP_GET_VARS['lang']) : $conf['general']['lang'];
$mode = ($HTTP_GET_VARS['mode']) ? (($HTTP_GET_VARS['fmode']) ? $HTTP_GET_VARS['fmode'] : $HTTP_GET_VARS['mode']) : $conf['general']['mode'];

if ($HTTP_GET_VARS['lang']) {
  $glob['query'].= "&lang=$lang";
	$glob['input'].= "<input type=\"hidden\" name=\"lang\" value=\"$lang\">";
}
if ($HTTP_GET_VARS['mode']) {
  $glob['query'].= "&mode=$mode";
	$glob['input'].= "<input type=\"hidden\" name=\"mode\" value=\"$mode\">";
}	

$tpl_path = $conf[general][tpl_path]."/$mode";

include "$tpl_path/globals.php";
if (is_file("$tpl_path/$lang/globals.php")) {
  include "$tpl_path/$lang/globals.php";
}

if ($HTTP_GET_VARS['forceextent']) {
	$ext = split(' ',$conf[map][defext]);
	if ($act == 'edition') $act = 'travel';
} elseif ($HTTP_GET_VARS['extent']) {
	$ext = split(' ',trim($HTTP_GET_VARS['extent']));
} else {
	$ext = split(' ',$conf[map][defext]);
}

list($extminx,$extminy,$extmaxx,$extmaxy) = split(' ',$conf[map][defext]);
$size = (($HTTP_GET_VARS['size']) and (strstr($HTTP_GET_VARS['size'],'x'))) ? $HTTP_GET_VARS['size'] :  $conf[map][defsize];
list($sizex,$sizey) = split('x',$size);
if ($sizex > 1200) $sizex = '1200';
if ($sizey > 1200) $sizey = '1200';

$conn = sig_connect();

checkfontlist($conf["map"]['path']);

// layer modification
if ($confdel and $drawlayer) {
	modlayer('killme!',$drawlayer);
	$drawlayer = '';
}
if ($editlay['add']) {
	if ($editlay['id']) {
		modlayer($editlay,$editlay['id']);
	} else {
		$drawlayer = modlayer($editlay,'');
	}
}

// points modification
if ((is_array($add)) and ($add[submit])) {
	addobj($add);
}

$userlayers = layerslist();

$zMap = ms_newMapObj($conf["map"]["path"].'/'.$conf["map"]["file"]);
$zMap->set('status', MS_ON);
$zMap->set('name', $conf[map][name]);
$zMap->set('shapepath', $conf[map][shapepath]);
$zMap->set('width', $sizex);
$zMap->set('height', $sizey);

$zWeb = $zMap->web;
$zWeb->set('imagepath',$conf["general"]["tmp_path"]."/");
$lys = array();
$lys = $zMap->getAllGroupNames();
foreach ($lys as $l) {
	$maplayer[] = $l;
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
	$fext = move_map($ext,$fsens);
	$zExtent = ms_newRectObj();
	$zExtent->setextent($fext[0],$fext[1],$fext[2],$fext[3]);
} else {
	$zExtent = ms_newRectObj();
	$zExtent->setextent($ext[0],$ext[1],$ext[2],$ext[3]);
}

$zClick = ms_newPointObj();
if ($act and ($refx and $refy) and (sizeof($ext) > 3)) {
	$refx = floor($refx*($sizex/$conf[globals][minimapx]));
	$refy = floor($refy*($sizey/$conf[globals][minimapy]));
	$zClick->setXY($refx,$refy,0);
	$zMap->zoomscale($scl*1000,$zClick,$sizex,$sizey,$zLimit,$zLimit);
} else {
	if (($act != "edition") and $click_x and $click_y) {
		$zClick->setXY($click_x,$click_y,0);
		$clicked = TRUE;
	} else {
		$zClick->setXY(floor($sizex/2),floor($sizey/2),0);
		$clicked = FALSE;
	}
	if ($clicked and (($act == "zoomin") or (!empty($fzoom)))) {
		$zMap->zoompoint(2,$zClick,$sizex,$sizey,$zExtent,$zLimit);
	} elseif ($clicked and (($act == "zoomout") or (!empty($fzoomout)))) {
		$zMap->zoompoint(-2,$zClick,$sizex,$sizey,$zExtent,$zLimit);		
	} elseif ($act == "edition") {
		$zMap->zoompoint(1,$zClick,$sizex,$sizey,$zExtent,$zLimit);		
		$coordx = pix2geo($click_x,$ext[0],$ext[2],$sizex) + $ext[0];
		$coordy = $ext[3] - pix2geo($click_y,$ext[1],$ext[3],$sizey);
		#$addville = domenu(surrounding($coordx,$coordy,10000),'');
	} elseif ($clicked and ($act == "travel")) {
		$zMap->zoompoint(1,$zClick,$sizex,$sizey,$zExtent,$zLimit);
	} elseif ($scl and $zClick and empty($fzoom) and empty($fzoomout)) {
		$zMap->zoompoint(1,$zClick,$sizex,$sizey,$zExtent,$zLimit);
		$act = "travel";
	}
}
#$zMap->set("width",$sizex);
#$zMap->set("height",$sizey);
$zImage    = $zMap->draw();
$zExtent   = $zMap->extent;
$ext = ext2array($zExtent);
$extexploded = implode(' ',$ext);

foreach($maplayer as $l) {
	if (@in_array(trim($l),$lay)) {
		$check = 'checked';
		$glob['query'].= "&layers[]=".urlencode($l);
	} else {
		$check = '';
	}
	$glob['layermenu'].= sprintf($g_layermenu,$check,$l,$l,$l,$l,$check,ucfirst($l));
}
if (is_array($userlayers)) {
  foreach ($userlayers as $ulnum=>$ul) {
    if ($drawlayer == $ulnum) {
      $glob['catmenu'].= "<option value=$ulnum selected style=background-color:#FFCC99>$ul[layername] ($ul[total])</option>";
    } else {
      $glob['catmenu'].= "<option value=$ulnum>$ul[layername] ($ul[total])</option>";
    }
  }
} 

${"check$interface"} = "checked";
$glob["lang$lang"] = "selected";
$glob["act".$act] = "checked";
$glob["size".$sizex."x".$sizey] = "selected";
$glob['sizex'] = $sizex;
$glob['sizey'] = $sizey;

if ($ext) {
	$glob['query'].= "&extent=".urlencode($extexploded);
	$glob['input'].= "<input type=\"hidden\" name=\"extent\" value=\"$extexploded\">";
}

$colwidth = $conf[globals][colwidth];

if (($drawlayer and ($drawlayer != 'x') and ($drawlayer != 'NEW'))) {
	$points = lcls_drawlayer($drawlayer);
	if (is_array($points)) {
		foreach ($points as $where=>$what) {
			$cdx = strtok($where, '/');
			$cdy = strtok('/');
			$what[1] = preg_replace("/\r?\n/","<br>",addslashes(str_replace('"',"'",$what[1])));
			$editlink = "<a href=localis.php?showid=$what[0]&drawlayer=$drawlayer".$glob['query'].">$texteedit</a>";
			$glob[maplocations].= sprintf($g_maplocations,$where,$where,($cdx-10),($cdy-10),($cdx+10),($cdy+10),$what[1],$what[1],$editlink);
			$lst.= sprintf($g_listitem,$drawlayer,$what[0],$glob[query],$what[0],$what[1]);
		}
		$list.= sprintf($g_list,$lst);
	}
}

if ($act == "edition") {
	lcls_drawpoint($coordx,$coordy);
}
# Create image, reference map & legend
$glob[imgsrc] = $zImage->saveWebImage(MS_PNG,0,0,-1);
$zRefer = $zMap->reference;
$zRefer->set('status',$conf[reference][status]);
$zRefer->set('width',$conf[reference][sizex]);
$zRefer->set('height',$conf[reference][sizey]);
$zRefer->set('image',$conf[reference][image]);
$zRef = $zMap->drawreferencemap();
$glob[refsrc] = $zRef->saveWebImage(MS_PNG,0,0,-1);
$zLegende = $zMap->drawLegend();
$glob[legsrc] = $zLegende->saveWebImage(MS_PNG,0,0,-1);
$scl = number_format($zMap->scale,0,',',' ');
$glob['scale'] = $scl;
$glob['query'].= "&scale=".urlencode($scl);
$glob['input'].= "<input type=\"hidden\" name=\"scale\" value=\"$scl\">";
$layertop = sprintf($g_layername, $textelayer, $userlayers[$drawlayer]['layername'], $drawlayer, 
                    $glob['query'], $textelayeredit, $drawlayer, $drawlayer, $glob['query'], $textelayerdelete);

echo inc("head");
echo inc("search");
if ($drawlayer and $dellayer) {
	$glob['right'] = $layertop.sprintf($g_confirmdelete, $texteconfirmdelete, $dellayer, $texteconfirmsubmit);
} elseif (($drawlayer == "NEW") or ($modlayer)){
	if ($modlayer) {
		list($edlid,$edlname,$edltype,$edlgroup,$edlcolor,$edlsize,$edlsymbol) = $userlayers[$modlayer];
		$glob['right'] = $layertop;
	}
	$glob['lid']     = $edlid;
	$glob['lname']   = $edlname;
	$glob['lgroup']  = $edlgroup;
	$glob['ltype']   = domenu($laytype,$edltype);
	$glob['lcolor']  = domenu($laycolors,$edlcolor);
	$glob['lsize']   = domenu($laysize,$edlsize);
	$glob['lsymbol'] = domenu($laysymbols,$edlsymbol);

	$glob['right'].= inc("editlayer");
} elseif ($showid or($act == "edition")) {
	if ($showid) {
		list($addstatus,$addnom,$adddesc,$addemail,$coordx,$coordy,$dotid) = getobj($showid);
	}
	$glob['dotid'] = $dotid;
	$glob['coordx'] = $coordx;
	$glob['coordy'] = $coordy;
	$glob['addnom'] = $addnom;
	$glob['adddesc'] = $adddesc;
	$glob['addemail'] = $addemail;
	$glob['statusmenu'] = domenu($pointstatus,$addstatus);
	
	$glob['right'] = $layertop.inc("edit");
} else {
	if (($drawlayer and ($drawlayer != 'x') and ($drawlayer != 'NEW'))) {
		$glob['right'].= $layertop.$list;
	}
}
echo inc("map");
echo inc("foot");
mysql_close($conn);

if (0 or $conf[gui][debug]) { echo "<pre style=font-size:80%;color:#990000>";print_r(get_defined_vars());echo "</pre>"; }
?>
