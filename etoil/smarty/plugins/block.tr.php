<?php

function smarty_block_tr($params, $content, &$smarty) {
	if ($content) {
		global $lang;
		if (isset($lang) and is_array($lang) and $lang) {
			if(isset($lang[$content])) {
				echo $lang[$content];  
			} else {
				echo $content;        
			}
		} else {
			echo $content;        
		}
  }
}
?>
