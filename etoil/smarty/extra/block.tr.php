<?php
function smarty_block_tr($params, $content, &$smarty) {
	global $lang;
	if ($content) {
		if(!empty($lang["$content"])) {
			echo $lang[$content];  
		} else {
			echo $content;        
		}
	}
}
?>
