<?  /* $Id: lib.php,v 1.31 2003/02/04 19:04:34 mose Exp $
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

function ext2array($z) { 
  return array($z->minx, $z->miny, $z->maxx, $z->maxy);
}

function sig_connect() {
  global $conf;
  $conn = mysql_connect($conf["database"]["db_host"],$conf["database"]["db_user"],$conf["database"]["db_pass"]);
	$conf["database"]["db_pass"] = '';
  if (!$conn) echo mysql_error();
  return $conn;
}

function sig_list($field, $conn, $cut=0) {
	# Fecth informations to build selects from mysql
  global $conf;
	if (ereg("select_list:\/\/(.*)",$field,$r)) {
		$f = explode(",",$r[1]);
		if(is_array($f)) {
			foreach($f as $ff) {
				$r = explode("->",$ff);
				$lis[] = $r[0];
     		$back[$r[0]] = $r[1];
			}
		}
	}
	$GLOBALS['listres'] = $lis;
	return $back;
} 

function layerslist() {
  global $conn,$conf;
  $query = "select * from layer";
  $res = mysql_db_query($conf[database][db_name],$query,$conn) or die(mysql_error());
  while ($r = mysql_fetch_array($res)) {
    $back["$r[layerid]"] = $r;
  }
  return $back;
}

function listobjects($layer) {
  global $conn,$conf;
  $query = "select * from layerobj as l left join object as o on l.objectid=o.id where l.layerid=$layer order by l.ranknum";
  $res = mysql_db_query($conf[database][db_name],$query,$conn) or die(mysql_error());
  while ($r = mysql_fetch_array($res)) {
    $back[] = $r;
  }
  return $back;
}

function listpoints($object,$ext='') {
  global $conn,$conf;
	if ($ext) {
		$where = "and ((d.E between $ext[0] and $ext[2]) and (d.N between $ext[1] and $ext[3]))";
	}
  $query = "select g.*, d.* from objdots as g left join dots as d on g.dotid=d.id where g.objectid=$object $where order by g.ranknum";
  $res = mysql_db_query($conf[database][db_name],$query,$conn) or die(mysql_error());
  while ($r = mysql_fetch_array($res)) {
    $back[] = $r;
  }
  return $back;
}

function getpoint($id) {
  global $conn,$conf;
  $query = "select * from dots where id=$id";
  $res = mysql_db_query($conf[database][db_name],$query,$conn) or die(mysql_error());
  $r = mysql_fetch_array($res);
  $back = array($r[E],$r[N]);
  return $back;
}

function getcalqueinfo($id) {
  global $conn,$conf;
  $query = "select * from layer where layerid=$id ";
  $res = mysql_db_query($conf[database][db_name],$query,$conn) or die(mysql_error());
  $r = mysql_fetch_array($res);
  $back = array($r[layername],$r[layertype],$r[layergroup],$r[layercolor],$r[layersize],$r[layersymbol]);
  return $back;
}


function listlines($layer,$ext='') {
  $obj = listobjects($layer);
  if (is_array($obj)) {
    foreach ($obj as $o) {
      $line = listpoints($o[id],$ext);
      $back[$o[id]] = array($o[name],$line);
    }
  }
  return $back;
}

function surrounding($x,$y,$delta) {
	global $conf, $conn;
	$minx = $x - $delta;
	$maxx = $x + $delta;
	$miny = $y - $delta;
	$maxy = $y + $delta;
	$query = "select * from ".$conf[general][sql_reftable]." where ";
	$query.= "$minx < ".$conf[map][coord_x]." and ";
	$query.= $conf[map][coord_x]." < $maxx and ";
	$query.= "$miny < ".$conf[map][coord_y]." and ";
	$query.= $conf[map][coord_y]." < $maxy";
	$res = mysql_db_query($conf[database][db_name],$query,$conn) or die($query."<br>2".mysql_error());
	if ($res) {
		while ($r = mysql_fetch_array($res)) {
			$n = $r[nom];
			$back[$n] = $n;
		}
		return $back;
	} else {
		return false;
	}
}

function getinfos($table,$id) {
	global $conf, $conn;
	$query = "select * from $table where id=$id;";
	$res = mysql_db_query($conf[database][db_name],$query,$conn) or die($query."<br>3".mysql_error());
	if ($res) {
		return mysql_fetch_array($res);
	} else {
		return false;
	}
}

function additem($nom,$email,$desc,$statut,$e,$n) {
	global $conf,$conn;
	$query = "insert into points (nom,email,description,statut,date,E,N) values ('$nom','$email','$desc','$statut',now(),$e,$n);";
	$res = mysql_db_query($conf[database][db_name],$query,$conn) or die($query."<br>".mysql_error());
}

function addobj($add) {
	global $conf,$conn;
	$query = "insert into metadata (title,content,status,date,signature) values ('";
	$query.= addslashes($add[nom])."','";
	$query.= addslashes($add[content])."','";
	$query.= addslashes($add[status])."',now(),";
	$query.= addslashes($add[signature])."')";
	$res = mysql_db_query($conf[database][db_name],$query,$conn) or die("function adobj($add)<hr>$query<hr>".mysql_error());
	echo "$query<hr>";
	$metaid = mysql_insert_id($conn);
	$query = "insert into object (name,meta) value ('".addslashes($add[nom])."',$metaid)";
	$res = mysql_db_query($conf[database][db_name],$query,$conn) or die("function adobj($add)<hr>$query<hr>".mysql_error());
	echo "$query<hr>";
	$objid = mysql_insert_id($conn);
	$query = "insert into dots (E,N) values ($add[x],$add[y])";
	$res = mysql_db_query($conf[database][db_name],$query,$conn) or die("function adobj($add)<hr>$query<hr>".mysql_error());
	echo "$query<hr>";
	$dotid = mysql_insert_id($conn);
	$query = "insert into objdots (dotid,objectid) values ($dotid,$objid)";
	$res = mysql_db_query($conf[database][db_name],$query,$conn) or die("function adobj($add)<hr>$query<hr>".mysql_error());
	echo "$query<hr>";
}

function inc($template) {
  global $conf,$lang,$mode,$glob;
	if (is_file($conf[general][tpl_path]."/$lang/$template.php")) {
		include $conf[general][tpl_path]."/$lang/$template.php";
	}
	$file = $conf[general][tpl_path]."/$mode/$template.html";
  if (!is_file($file)) {
		$file = $conf[general][tpl_path]."/$template.html";
	}
  if (is_file($file)) {
  	$outp = preg_replace(array("/(\\$([_a-zA-Z0-9]*)\\$)/e", "/(\\$\.([_a-zA-Z0-9]*)\\$)/e", "/(\\$\+([_a-zA-Z0-9]*)\\$)/e"),
		                     array("\$GLOBALS['texte\\2']", "\$conf['globals']['\\2']", "\$glob['\\2']"),
												 trim(implode('', file($file))));
		return $outp;
  } else {
    return "<div style=background:#CC3300;padding:2;margin:1>error handling '$template' Template.</div>";
  }
}

function build_list($found,$qu,$eff) {
  global $tempath, $tpl, $PHP_SELF, $resultats, $myc, $coords, $sizex, $sizey, $layer_query, $type, $conf;
	// todo : make forcescale variable from conf
	$args = @implode('&',$qu);
  if (!$found) {
    $list.= $conf[gui][noresult];
  } else {
    if (is_array($resultats)) {
			foreach ($resultats as $vres) {
				$ouca = $coords[$vres];
				$list.= "<div class=base id=109><a href=localis.php?x=".$ouca[x]."&y=".$ouca[y];
				$list.= "&v=".urlencode($vres)."&size={$sizex}x$sizey&type=$myc&".$layer_query."forcescale=1200&$args ";
				$list.= "class=base>$vres</a></div>";
				foreach ($found[$vres] as $kk) {
					$list.= "<div class=list><a href=\"file.php?table=$myc&id=".$kk['cid']."\" target=_new>";
					$list.= "<img src=images/mapzoom.png width=8 height=8 hspace=2 vspace=0 border=0 alt='look' align=baseline>&nbsp;";
					$list.= "$kk[name]</a></div>\n";
					$maplist[$vres].= "<div class=list><a href=file.php?table=$myc&id=".$kk['cid']." target=_new><b>$kk[name]</b></a><br>".$kk[shortdesc]."</div>"; 
				}
			}
		}
  }
	$GLOBALS[maplist] = $maplist;
  $GLOBALS[llist] = $list;
  $GLOBALS[lrequete] = @array_pop($eff);
  return inc('listitem');
}

function pix2geo($x,$minx,$maxx,$size) {
	return floor(($x / $size) * ($maxx - $minx));
}

function geo2pix($x,$minx,$maxx,$size) {
	return floor($size * ($x - $minx) / ($maxx - $minx));
}

function move_map($ext,$sens) {
	if (empty($ext[0])) $ext[0] = 0;
	$maplen = ($ext[2] - $ext[0])/2;
	$mapwid = ($ext[3] - $ext[1])/2;
	for ($i=0;$i<strlen($sens);$i++) {
		switch($sens{$i}) { 
			case 'l' :
				$ext[0] = floor($ext[0] - $maplen);
				$ext[2] = floor($ext[2] - $maplen);
			break;
			case 'r' :
				$ext[0] = floor($ext[0] + $maplen);
				$ext[2] = floor($ext[2] + $maplen);
			break;
			case 't' :
				$ext[1] = floor($ext[1] + $mapwid);
				$ext[3] = floor($ext[3] + $mapwid);
			break;
			case 'b' :
				$ext[1] = floor($ext[1] - $mapwid);
				$ext[3] = floor($ext[3] - $mapwid);
			break;
		}
	}
	return $ext;
}

function dbf_flag($click_x,$click_y, $qx, $qy) {
  global $conf, $add_nom, $qinfo, $x, $y, $nature, $ext, $sizex, $sizey;
	$path = $conf[general][tmp_path];
  $UNIQUE_ID = $pref.uniqid('flag_');
  $dbffile = "$path/$UNIQUE_ID.dbf";
	$dbf_inf = explode('/',str_replace('dbf://','',$conf[map][dbf_def]));
	$i=0;
	foreach($dbf_inf as $d) {
		$dd = explode(',',$d);
		foreach($dd as $ddd) {
			$dbfdef[$i][] = $ddd;
		}
		$i++;
	}
	$dbf = @dbase_create($dbffile,$dbfdef) or die ("dbf creation failed");
	$did = @dbase_open("$dbffile",2) or die ("Unable to open dbf file");
	$shapefile = ms_newShapefileObj("$path/$UNIQUE_ID", 1) or die("Error creating shapefile.");
	$point = ms_newpointobj();
	$GLOBALS['m']["$add_nom"][x] = $click_x;
	$GLOBALS['m']["$add_nom"][y] = $click_y;
	$GLOBALS['coords']["$add_nom"] = array('x' => $qx, 'y' => $qy );
	$point->setXY($qx,$qy);
	$shapefile->addPoint($point);
	$tmp = array(trim($v),$qx,$qy);
	dbase_add_record($did,$tmp);
  $shapefile->free();
  dbase_close($did);
  return $UNIQUE_ID;
}

function clean_city($a) {
  return preg_replace(array("/ /","/'/"),array("%","%"),$a);
}

function domenu($list,$it) {
  if (is_array($list)) {
  	foreach ($list as $k=>$l) {
    	if ((is_array($it) and in_array($k,$it)) or ($it == $k)) {
				$ll = str_replace(' ','',strtolower($l));
      	$back.= "<option value='$k' selected>$l\n";
    	} else {
      	$back.= "<option value='$k'>$l\n";
    	}
  	}
 		return "$back";
 	}
}

function doicons($list,$it) {
  if (is_array($list)) {
  	foreach ($list as $k=>$l) {
    	if ((is_array($it) and in_array($k,$it)) or ($it == $k)) {
				$ll = str_replace(' ','',strtolower($l));
      	$back.= "<option value='$k' selected>$l\n";
    	} else {
      	$back.= "<option value='$k'>$l\n";
    	}
  	}
 		return "$back";
 	}
}

function lcls_drawpoint($x,$y) {
	global $zMap, $zImage;
	$zUser = ms_newLayerObj($zMap);
	$zUser->set("status", MS_ON);
	$zUser->set("type", MS_LAYER_POINT);
	$zUser->set("name", "Point de Saisie");
	$zUclass = ms_newClassObj($zUser);
	$zUclass->set("symbolname", "flag2");
	$zUclass->set("status", MS_ON);
	$zUshape = ms_newShapeObj(MS_SHAPE_POINT);
	$zUline = ms_newLineObj();
	$zUline->addXY($x,$y);
	$zUshape->add($zUline);
	if (is_object($zUshape)) {
		$zUshape->draw($zMap, $zUser, $zImage, 1, "saisie");
	}
}

function lcls_drawlayer($drawlayer) {
	global $zMap, $zImage, $userlayers, $ext, $sizex, $sizey;
	if ($userlayers["$drawlayer"]["layertype"] == 'point') {
		$layertype = MS_LAYER_POINT;
		$shapetype = MS_SHAPE_POINT;
	} elseif ($userlayers["$drawlayer"]["layertype"] == 'line') {
		$layertype = MS_LAYER_LINE;
		$shapetype = MS_SHAPE_LINE;
	}
	$zUser = ms_newLayerObj($zMap);
	$zUser->set("status", MS_ON);
	$zUser->set("type", $layertype);
	$zUser->set("classitem", "item");
	$zUser->set("name", $userlayers["$drawlayer"]["layername"]);
	$zUser->set("group", $userlayers["$drawlayer"]["layergroup"]);
	$zUclass = ms_newClassObj($zUser);
	$zUclass->set("name", $userlayers["$drawlayer"]["layername"]);
	if ($userlayers[$drawlayer][layercolor]) {
		$zUclass->set("color", "{$userlayers[$drawlayer][layercolor]}");
	}
	if ($userlayers["$drawlayer"]["layersymbol"]) {
		$zUclass->set("symbolname", $userlayers["$drawlayer"]["layersymbol"]);
	}
	$zUclass->set("size", $userlayers["$drawlayer"]["layersize"]);
	
	$listlines = listlines($drawlayer,$ext);
	if (is_array($listlines)) {
	  foreach ($listlines as $o=>$l) {
		  if (is_array($l[1])) {
				$zUclass->set("status", MS_ON);
				$zUshape = ms_newShapeObj($shapetype);
				$zUline = ms_newLineObj();
				foreach ($l[1] as $drawpoint) {
				  $zUline->addXY($drawpoint[E], $drawpoint[N],0);
					$imgx = geo2pix($drawpoint[E],$ext[0],$ext[2],$sizex);
					$imgy = $sizey - geo2pix($drawpoint[N],$ext[1],$ext[3],$sizey);
					$pointslist["$imgx/$imgy"] = array($o,$l[0]);
				}
				$zUshape->add($zUline);
			}
		}
	}
	if (is_object($zUshape)) {
		$zUshape->draw($zMap, $zUser, $zImage, 1, "test");
	}
	return $pointslist;
}

function lcls_drawline($drawlayer, $listlines, $edit=0, $flag='') {
  global $zMap, $zImage, $userlayers;
  $zUser = ms_newLayerObj($zMap);
  $zUser->set("status", 1);
  $zUser->set("type", MS_LAYER_LINE);
  $zUser->set("classitem", "point");
  $zUser->set("name", "User Input lines");
  $zUser->set("group", "fond");
  $zUclass = ms_newClassObj($zUser);
  $zUclass->set("name", $userlayers[$drawlayer][layername]);
  $zUclass->set("color", 12);
  $zUclass->set("symbolname", "circle");
  if (!$edit) {
    $zUclass->set("size", 3);
  } else {
    $zUclass->set("size", 7);
    $zUclass->set("overlaycolor", 0);
    $zUclass->set("overlaysymbolname", "circle");
    $zUclass->set("overlaysize", 3);
  } 
  if (is_array($listlines)) {
    foreach ($listlines as $o=>$l) {
      if (is_array($l)) {
        $zUclass->set("status", MS_ON);
        $zUshape = ms_newShapeObj(MS_SHAPE_LINE);

        $zUline = ms_newLineObj();
        foreach  ($l as $drawpoint) {
          $zUline->addXY($drawpoint[E], $drawpoint[N]);
        }
        $zUshape->add($zUline);
      }
    }
    if (is_object($zUshape)) {
    $zUshape->draw($zMap, $zUser, $zImage, 1, "test");
    }
  } 
  if ($edit) {
    if (is_array($l)) {
      $zUser = ms_newLayerObj($zMap);
      $zUser->set("status", 1);
      $zUser->set("type", MS_LAYER_POINT);
      $zUser->set("classitem", "point");
      $zUser->set("name", "User Input dots");
      $zUser->set("group", "fond");
      $zUclass = ms_newClassObj($zUser);
      $zUclass->set("color", 12);
      $zUclass->set("symbolname", "circle");
      $zUclass->set("size", 10);
      $zUclass->set("overlaysize", 6);
      $zUclass->set("overlaysymbolname", "circle");
      $zUclass->set("overlaycolor", 0);
      $zUclass->set("status", MS_ON);
      $zUshape = ms_newShapeObj(MS_SHAPE_POINT);

      $zUline = ms_newLineObj();
      foreach  ($l as $drawpoint) {
        $zUline->addXY($drawpoint[E], $drawpoint[N]);
      }
      $zUshape->add($zUline);
      $zUshape->draw($zMap, $zUser, $zImage, 1, "test");
    }
  } 
  if ($flag) {
    $flg = getpoint($flag);
    $zUser = ms_newLayerObj($zMap);
    $zUser->set("status", 1);
    $zUser->set("type", MS_LAYER_POINT);
    $zUser->set("classitem", "point");
    $zUser->set("name", "User Input Flag");
    $zUser->set("group", "fond");
    $zUclass = ms_newClassObj($zUser);
    $zUclass->set("color", 12);
    $zUclass->set("symbolname", "flag2");
    $zUclass->set("size", 40);
    $zUclass->set("status", MS_ON);
    $zUshape = ms_newShapeObj(MS_SHAPE_POINT);
    
    $zUline = ms_newLineObj();
    $zUline->addXY($flg[0], $flg[1]);
    $zUshape->add($zUline); 
    $zUshape->draw($zMap, $zUser, $zImage, 1, "test");
    
  }
} 

function checkfontlist($path) {
	if (!is_file("$path/fonts/fontset")) {
		$dir = opendir("$path/fonts");
		if ($dir) {
			while (false !== ($dd = readdir($dir))) {
				if ($dd and (substr($dd,0,1) != '.') and (substr($dd,-4,4) == '.ttf')) {
					$fonts.= strtolower(substr(basename($dd),0,-4))."    $path/fonts/$dd\n";
				}
			}
		}
		closedir($dir);
		$fp = fopen("$path/fonts/fontset","w+");
		fputs($fp,$fonts);
		fclose($fp);
	}

}
?>
