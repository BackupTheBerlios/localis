<?php

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

function tra($str) {
	global $lang;
	if (!empty($lang[$str])) {
		return $lang[$str];
	} else {
		return $str;
	}
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
