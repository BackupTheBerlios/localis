<?  /* $Id: lib.php,v 1.23 2002/10/28 04:30:07 mose Exp $
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
  $res = mysql_db_query($req[base][1],$query,$conn) or die(mysql_error());
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
	$res = mysql_db_query($conf[database][db_name],$query,$conn) or die(mysql_error());
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
	$res = mysql_db_query($conf[database][db_name],$query,$conn) or die(mysql_error());
	if ($res) {
		return mysql_fetch_array($res);
	} else {
		return false;
	}
}

function additem($where,$city,$nom,$email,$url,$notes) {
	global $conf,$conn;
	$query = "insert into $where (ville,nom,email,url,date,notes) values ('$city','$nom','$email','$url',now(),'$notes');";
	$res = mysql_db_query($conf[database][db_name],$query,$conn) or die(mysql_error());
}

# Fonction semi recursive, genere le html en fonction des nouveaux templates
function inc($template) {
  global $conf,$lang;
	$file = $conf[general][tpl_path]."/$lang/$template.html";
  if (!is_file($file)) {
		$file = $conf[general][tpl_path]."/$template.html";
	}
  if (is_file($file)) {
  	$outp = preg_replace(array("/\\$([_a-zA-Z0-9]*)/e"),array("\$GLOBALS['\\1']"),trim(implode('', file($file))));
  	while (ereg("\+?Array.([_a-zA-Z0-9\.]+\+?)",$outp,$matchs)) {
				# For string concatenation in template
				$mth = str_replace('+','',$matchs[0]);
			  $pre = trim(strtok($mth."#",'.'));
			  $section = trim(strtok('.'));
			  $object = trim(strtok('#'));
				$outp = str_replace('$','',str_replace($matchs[0],$conf["$section"]["$object"],$outp));
		}
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
					$maplist[$vres].= "<div class=list><a href=file.php?table=$type&id=".$kk['cid']." target=_new><b>$kk[name]</b></a><br>".$kk[shortdesc]."</div>"; 
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
?>
