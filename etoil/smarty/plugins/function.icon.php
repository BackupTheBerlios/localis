<?php
function smarty_function_icon($params, &$smarty) {
	if (!isset($params['type']) or !$params['type'] or !is_file("img/ico/".$params['type'].".png")) $params['type'] = 'info';
	return '<img src="img/ico/'. $params['type'] .'.png" width="14" height="14" alt="'. $params['type'] .'" border="0" hspace="2" vspace="0" align="baseline" />';
}
?>
