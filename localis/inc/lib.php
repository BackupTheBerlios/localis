<?  /* $Id: lib.php,v 1.5 2002/10/16 21:22:49 mastre Exp $
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

function sig_query($select,$cond,$conn) {
  global $conf;
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
	if ($cond) { $more = "where ".@implode(" and ",$cond); }
  $query = "select distinct ".$req[table][1].".* from ".$req[table][1]." left join ".$req[base][2].'.'.$req[table][2]." on ".$req[table][2].".".$req[champ][2]."=".$req[table][1].".".$req[champ][1]." $more;";
  $res = mysql_db_query($req[base][1],$query,$conn);
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

# Fonction semi recursive, genere le html en fonction des nouveaux templates
function inc($template) {
  global $conf;
  if (is_file($conf[general][tpl_path]."/$template.html")) {
    $file = $conf[general][tpl_path]."/$template.html";
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

function prepare_list($wh,$conn,$type) {
  global $db,$conf;
  $sig_res = sig_query($type,$wh,$conn);
  if ($sig_res) {
    asort($sig_res);
    foreach ($sig_res as $sr) {
      $s["$sr[ville]"][] = array('nom' => $sr[nom], 'id' => $sr[id]);
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
  global $tempath, $tpl, $PHP_SELF, $resultats, $coords, $sizex, $sizey, $layer_query;
	$args = @implode('&',$qu);
  if (!$found) {
    $list.= "Aucun resultat.";
  } else {
    foreach ($resultats as $ville) {
			$ouca = $coords[$ville];
      $list.= "<div class=base id=109><a href=localis.php?x=".$ouca[x]."&y=".$ouca[y];
			$list.= "&v=".urlencode($ville)."&size=400x400&".$layer_query."forcescale=188&$args ";
			$list.= "class=base>$ville</a></div>";
      foreach ($found[$ville] as $kk) {
				$list.= "<div class=list><a href=http://#/fiche.asp?id=".$kk['id']." target=_new>";
        $list.= "<img src=images/mapzoom.png width=8 height=8 hspace=2 vspace=0 border=0 alt='look' align=baseline>&nbsp;";
				$list.= "$kk[nom]</a></div>\n";
				$maplist[$ville].= "<div class=list>- <a href=#/fiche.asp?id=".$kk['id']." target=_new>$kk[nom]</a></div>"; 
      }
    }
  }
	$GLOBALS[maplist] = $maplist;
  $GLOBALS[llist] = $list;
  $GLOBALS[lrequete] = @implode("<br>\n",$eff);
  return inc('listitem');
}

function geo2pix($x,$minx,$maxx,$size) {
	return floor($size * ($x - $minx) / ($maxx - $minx));
}

function dbf_gen($base,$jbase,$villes,$cond,$conn,$pref='') {
  global $conf, $qinfo, $x, $y, $nature, $ext, $sizex, $sizey;
	$path = $conf[general][tmp_path];
  $UNIQUE_ID = $pref.uniqid('');
  $dbffile = "$path/$UNIQUE_ID.dbf";
  $dbfdef = array(
    array("NOM","C",64,0),
    array("ABS_C_LIEU","N",12,4),
    array("ORD_C_LIEU","N",12,4)
	);
	$dbf = @dbase_create($dbffile,$dbfdef) or die ("Creation du dbf impossible");
	$did = @dbase_open("$dbffile",2) or die ("Ouverture du dbf impossible");
	$shapefile = ms_newShapefileObj("$path/$UNIQUE_ID", 1) or die("Error creating shapefile.");
	$point = ms_newpointobj();
  if (is_array($villes)) {
    foreach ($villes as $v) {
      $vc = clean_city($v);
      $query = "select ABS_C_LIEU as abs, ORD_C_LIEU as ord from $jbase where NOM like '$vc';";
      $res = mysql_db_query($conf[database][db_name],$query,$conn);
      if ($res and mysql_numrows($res)) {
        $qx = mysql_result($res,0,"abs");
				$GLOBALS['m'][$v][x] = geo2pix($qx,$ext[0],$ext[2],$sizex);
        $qy = mysql_result($res,0,"ord");
				$GLOBALS['m'][$v][y] = $sizey - geo2pix($qy,$ext[1],$ext[3],$sizey);
				$point->setXY($qx,$qy);
				$shapefile->addPoint($point);
				$tmp = array(trim($v),$qx,$qy);
				$GLOBALS['coords']["$v"] = array('x'=>$qx, 'y'=>$qy);
				dbase_add_record($did,$tmp);
      } else {
				// echo "$query <br>\n";
			}
    }
  }
  $shapefile->free();
  dbase_close($did);
  return $UNIQUE_ID;
}

function clean_city($a) {
  return preg_replace(array("/ /","/'/","/-/"),array("%","%","%"),$a);
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
  } else {

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
