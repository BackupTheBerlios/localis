<?php

//this script may only be included - so its better to die if called directly.
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false) {
  header("location: index.php");
  exit;
}

function smarty_prefilter_tr($source) {
  $return = preg_replace_callback('/(?s)(\{tr[^\}]*\})(.+?)\{\/tr\}/', '_translate_lang', preg_replace ('/(?s)\{\*.*?\*\}/', '', $source));
  return $return;
}

function _translate_lang($key) {
  global $lang;
	if(!empty($lang[$key[2]])) {
		if ($key[1] == "{tr}") {
			return $lang[$key[2]];
		} else {
			return $key[1].$lang[$key[2]]."{/tr}";
		}
	} elseif (strstr($key[2], "{\$")) {
		 return $key[1].$key[2]."{/tr}";
	} else {
		 return $key[2];
	}
}
?>
