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

?>
