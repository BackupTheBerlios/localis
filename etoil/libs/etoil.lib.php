<?php

function import_track($file,$format,$cs="wgs84") {
	$msg="import succeed !";
	if (!($handle=fopen($file,"rb"))) return ("error: cannot open $file !");
	$_SESSION['track'] = array(); // vide la var de session
	$bool_ok=true;
	if ($_REQUEST['tf_dir_import']=="yes") {
		global $db; 
		$i=1;
		$p_name=substr($_FILES['trackfileimp']['name'],0,strlen($_FILES['trackfileimp']['name'])-4);
		if ( $_SESSION['filtre']['discp']=="none") {
		$msg="ERREUR d'IMPORT: vous devez s�lectionner une discipline !";
		$bool_ok=false;
		}
	}
	while (!feof($handle) && $bool_ok) {
		$line=fgets($handle);
		$tb=explode(" ",$line);
		$zprec="-9999";
		if ($tb[0]=="T" || $tb[0]=="W") { // ligne de coordonn�es (W est pour les routes)
			if ($tb[0]=="W") $ofsi=1; // dans le cas des routes on a un champ en plus au d�but
			$tb[2]=substr($tb[2 + $ofsi],1); // enl�ve le car E
			$tb[3]=substr($tb[3 + $ofsi],1); // enl�ve le car N
			//echo "N=$tb[2], E=$tb[3], Z=$tb[6] => "; //" ".$tb[6].
			// on g�re l'ffset d'altitude, je ne sais pas si c'est judicieux...
			$zorig=$tb[6 + $ofsi];
			$cmd="cs2cs +proj=latlong +datum=WGS84 +to +init=lambfr:27585 <<EOF\n".$tb[3]." ".$tb[2]."\nEOF\n";
			$out=shell_exec($cmd);
			//echo "cmd out# ".$out."<br />";
			// renvoie X (tab) y (espace) offset z
			$out=str_replace(chr(9)," ",$out); // remplace le tab par l'espace
			$tb=explode(" ",$out);
			//print_r($tb);
			if ($zorig >0) {
				$zprec=$zorig + $tb[2];
			}
			$_SESSION['track'][]=floor($tb[0])." ".floor($tb[1])." ".$zprec;
		} elseif ($tb[0]=="R") { // dans les fichiers rte "routes" on a le nom de la route
			if (substr($line,6) != "") $p_name=substr($line,6);
		} elseif ($_REQUEST['tf_dir_import']=="yes" && count($_SESSION['track'])>0)  {
			// si import direct, enregistre LES morceaux avec des indices _$i
			$addp=$db->add_parcours($p_name."_".$i,($_REQUEST['usertrck']!="" ? $_REQUEST['usertrck'] : $_SESSION['me']),$_SESSION['filtre']['discp'],$_SESSION['track'],0,0,$_REQUEST['marqimp']);
			if (!$addp) $msg.="Insertion ne fonctionne pas pour le parcours d'indice $i\n";
			$_SESSION['track']=array();
			$i++;
		}
	} // fin boucle sur les lignes du fichier
	if ($_REQUEST['tf_dir_import']=="yes" && count($_SESSION['track'])>0) { 
		$addp=$db->add_parcours($p_name."_".$i,$_SESSION['me'],$_SESSION['filtre']['discp'],$_SESSION['track']);
		if (!$addp) $msg.="Insertion ne fonctionne pas pour le parcours d'indice $i\n";
		}
	else $i--;
	
	if ($_REQUEST['tf_dir_import']=="yes") $msg.="; $i tron�ons import�s avec le pr�fixe $p_name";
	fclose($handle);
	return("<PRE>".$msg."</PRE>");
}
function list_dir($path,$pattern,$i) {
	$back = false;
	if (!is_dir($path)) {
		return false;
	} else {
		$h = opendir($path);
		while ($file = readdir($h)) {
			if (preg_match($pattern,$file,$m)) {
				$back[] = $m[$i];
			}
		}
		closedir($h);
	}
	return $back;
}

function errorlogin($login,$pass) {
	if ($login == 'admin' && $pass == 'damin') {
		return false;
	} else {
		return "sorry, impossible";
	}
}

function debug($var,$die=false) {
	global $$var;
	echo '<span class="debugtitle">debug : $'.$var.'</span><br />';
	echo '<pre class="debug">';
	var_dump($$var);
	echo "</pre>";
	if ($die) die;
}

function tra($str) {
	global $lang;
	if (!empty($lang[$str])) {
		return $lang[$str];
	} else {
		return $str;
	}
}

function exact_time($time) {
  $float = strtok($time,' ');
  $sec = strtok(' ');
  return $sec + $float;
}

function elapsed_time() {
	return number_format(exact_time(microtime()) - exact_time(TIMER_START),4);
}

function pix2geo($x,$minx,$maxx,$size) {
  return floor(($x / $size) * ($maxx - $minx));
}

function geo2pix($x,$minx,$maxx,$size) {
  return floor($size * ($x - $minx) / ($maxx - $minx));
}

function checkfontlist($path) {
	$fonts = '';
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
