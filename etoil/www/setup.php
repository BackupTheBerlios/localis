<?php
/* --------------------------------------------------------------- */
define('TIMER_START', microtime());
define('PWWW', dirname(__FILE__).'/');
define('PROOT', dirname(dirname(__FILE__)).'/');
session_start();
/* --------------------------------------------------------------- */
error_reporting(E_ALL);
ini_set('register_globals','off');
ini_set('error_prepend_string','<div class="phperror">');
ini_set('error_append_string','</div>');
if (get_magic_quotes_gpc()) {
  foreach($_REQUEST as $k=>$v) {
    if (!is_array($_REQUEST[$k])) $_REQUEST[$k] = stripslashes($v);
  } 
}
require_once (PROOT.'libs/etoil.lib.php');
/* --------------------------------------------------------------- */
if (isset($_REQUEST['lang']) and is_file(PROOT."lang/".$_REQUEST['lang'].".php")) {
	$_SESSION['lang'] = $_REQUEST['lang'];
}
if (isset($_SESSION['lang']) and $_SESSION['lang'] != 'fr') {
	$language = $_SESSION['lang'];
} else {
	$language = 'fr';
}
$langs = list_dir(PROOT.'lang',"/^([a-z]*)\.php$/",1);
/* --------------------------------------------------------------- */

require_once (PROOT.'libs/setup_smarty.php');

if ($language and is_file(PROOT."lang/$language.php")) {
	include PROOT."lang/$language.php";
}
if (!isset($title)) {
	$title = '';
}
// temp values
$feedback = array();
$smarty->assign_by_ref('feedback',$feedback);
$smarty->assign('mw','400');
$smarty->assign('mh','400');
$smarty->assign('b','25');
$smarty->assign('language', $language);
$smarty->assign('langs', $langs);
$smarty->assign('url', basename($_SERVER['PHP_SELF']));
$smarty->assign('title', $title);

if (!empty($db)) {
	include (PROOT.'libs/psql.php');
}
?>
