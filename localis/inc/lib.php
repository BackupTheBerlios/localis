<?  /* $Id: lib.php,v 1.27 2003/02/02 08:42:07 mose Exp $
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
  $query = "select * from layertogroup as l left join object as o on l.objectid=o.id where l.layerid=$layer order by l.ranknum";
  $res = mysql_db_query($conf[database][db_name],$query,$conn) or die(mysql_error());
  while ($r = mysql_fetch_array($res)) {
    $back[] = $r;
  }
  return $back;
}

function listpoints($object) {
  global $conn,$conf;
  $query = "select g.*, d.* from groupofdots as g left join dots as d on g.dotid=d.id where g.objectid=$object order by g.ranknum";
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


function listlines($layer) {
  $obj = listobjects($layer);
  if (is_array($obj)) {
    foreach ($obj as $o) {
      $line = listpoints($o[id]);
      $back[$o[id]] = $line;
    }
  }
  return $back;
}

function sig_query($select,$cond,$conn,$owh='') {
  global $conf;
	$req = array();
	if ($t = str_replace('mysql://','',$conf[select][$select])) {
		$data = explode('/',$t);
		foreach ($data as $d) {
			$i++;
			$dbinfo = explode(',',$d);
			$req[base][$i] = $dbinfo[0];
			$req[table][$i] = $dbinfo[1];
			$req[champ][$i] = $dbinfo[2];
		}
	}
	if ($cond) { $more = " where ".@implode(" and ",$cond); }
	if ($owh) { $more .= " and ".@implode(" or ".$req[table][1].'.',$owh); }
  $query = "select distinct ".$req[table][1].".* from ".$req[table][1]." ";
	if (($req[base][2]) and ("$req[base][2]/$req[table][2]/$req[champ][2]" != "$req[base][&]/$req[table][&]/$req[champ][&]")) {
		$query.= "left join ".$req[base][2].'.'.$req[table][2]." on ".$req[table][2].".".$req[champ][2]."=".$req[table][1].".".$req[champ][1]." ";
	}
	$query.= "$more limit 50;";
  $res = mysql_db_query($req[base][1],$query,$conn) or die($query."<br>1".mysql_error());
  if ($res) {
    $i = 1;
    while ($r = mysql_fetch_array($res)) {
      $back[$i] = $r;
      $i++;
    }
    return $back;
  } else {
    return false;
  }
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

function additem($nom,$email,$description,$statut,$latitude,$longitude) {
	global $conf,$conn;
	$query = "insert into points (nom,email,description,statut,date,E,N) values ('$nom','$email','$description','$statut',now(),$longitude,$latitude);";
	$res = mysql_db_query($conf[database][db_name],$query,$conn) or die($query."<br>4".mysql_error());
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

function prepare_list($wh,$conn,$type,$owh='') {
  global $db,$conf;
  $sig_res = sig_query($type,$wh,$conn,$owh);
	$ii = strtok(str_replace('rows://','',$conf[infos][$type]),'/');
	$datas = explode(',',$ii);
	$cityname = $datas[0];
	$cid = $datas[1];
	$name = $datas[2];
	$shortdesc = $datas[3];
  if ($sig_res) {
    asort($sig_res);
    foreach ($sig_res as $sr) {
      $s["$sr[$cityname]"][] = array('cid' => $sr[$cid], 'shortdesc' => $sr[$shortdesc], 'name' => $sr[$name]);
    }
    ksort($s);
    $GLOBALS[nbres] = count($sig_res);
    $GLOBALS[nbresresultats] = count($s);
    $GLOBALS[found] = $s;
    $GLOBALS[resultats] = array_keys($s);
  }
  return true;
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
	global $conf;
	if (empty($ext[0])) $ext[0] = 0;
	$maplen = ($ext[2] - $ext[0])/2;
	$mapwid = ($ext[3] - $ext[1])/2;
	switch($sens) { 
		case $conf[gui][moveleft_button] :
			$ext[0] = floor($ext[0] - $maplen);
			$ext[2] = floor($ext[2] - $maplen);
		break;
		case $conf[gui][moveright_button] :
			$ext[0] = floor($ext[0] + $maplen);
			$ext[2] = floor($ext[2] + $maplen);
		break;
		case $conf[gui][moveup_button] :
			$ext[1] = floor($ext[1] + $mapwid);
			$ext[3] = floor($ext[3] + $mapwid);
		break;
		case $conf[gui][movebottom_button] :
			$ext[1] = floor($ext[1] - $mapwid);
			$ext[3] = floor($ext[3] - $mapwid);
		break;
	}
	return $ext;
}

function dbf_gen($base,$jbase,$vres,$cond,$conn,$owh='',$pref='') {
  global $conf, $qinfo, $x, $y, $nature, $ext, $sizex, $sizey;
	$path = $conf[general][tmp_path];
  $UNIQUE_ID = $pref.uniqid('');
  $dbffile = "$path/$UNIQUE_ID.dbf";
	$dbf_inf = explode('/',str_replace('dbf://','',$conf[map][dbf_def]));
	$i=0;
	foreach($dbf_inf as $d) {
		$dd = explode(',',$d);
		foreach($dd as $ddd) {
			$dbfdef[$i][] = $ddd;
		}
	$i+=1;
	}
	$dbf = @dbase_create($dbffile,$dbfdef) or die ("dbf creation failed");
	$did = @dbase_open("$dbffile",2) or die ("Unable to open dbf file");
	$shapefile = ms_newShapefileObj("$path/$UNIQUE_ID", 1) or die("Error creating shapefile.");
	$point = ms_newpointobj();
  if (is_array($vres)) {
    foreach ($vres as $v) {
      $vc = clean_city($v);
      $query = "select ".$conf[map][coord_x]." as abs, ".$conf[map][coord_y]." as ord from $jbase where ".$conf[general][sql_cityname]." like '$vc';";
      $res = mysql_db_query($conf[database][db_name],$query,$conn);
      if ($res and mysql_numrows($res)) {
        $qx = mysql_result($res,0,"abs");
				$GLOBALS['m'][$v][x] = geo2pix($qx,$ext[0],$ext[2],$sizex);
        $qy = mysql_result($res,0,"ord");
				$GLOBALS['m'][$v][y] = $sizey - geo2pix($qy,$ext[1],$ext[3],$sizey);
				$point->setXY($qx,$qy);
				$shapefile->addPoint($point);
				$tmp = array(utf8_encode(trim($v)),$qx,$qy);
				$GLOBALS['coords']["$v"] = array('x'=>$qx, 'y'=>$qy);
				dbase_add_record($did,$tmp);
			}
    }
  }
  $shapefile->free();
  dbase_close($did);
  return $UNIQUE_ID;
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

function tmpclean($id) {
	global $conf;
	@unlink($conf[general][tmp_path].'/'.$id.'.dbf');
	@unlink($conf[general][tmp_path].'/'.$id.'.shx');
	@unlink($conf[general][tmp_path].'/'.$id.'.shp');
	@unlink($conf[general][tmp_path].'/'.$id.'.png');
}

function lcls_drawlayer($drawlayer) {
	global $zMap, $zImage, $userlayers;
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
	$zUser->set("classitem", "point");
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
	
	$listlines = listlines($drawlayer);
	if (is_array($listlines)) {
	  foreach ($listlines as $o=>$l) {
		  if (is_array($l)) {
				$zUclass->set("status", MS_ON);
				$zUshape = ms_newShapeObj($shapetype);
				$zUline = ms_newLineObj();
				foreach ($l as $drawpoint) {
				  $zUline->addXY($drawpoint[E], $drawpoint[N]);
				}
				$zUshape->add($zUline);
			}
		}
	}
	if (is_object($zUshape)) {
		$zUshape->draw($zMap, $zUser, $zImage, 1, "test");
	}
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

?>
