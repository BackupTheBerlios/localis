<?php
/* --------------------------------------------------------------- */
define('TIMER_START', microtime());
define('PWWW', dirname(__FILE__).'/');
define('PROOT', dirname(dirname(__FILE__)).'/');
define ("MSIE",strstr($_SERVER["HTTP_USER_AGENT"],"MSIE")); // si MSIE on affiche un message d'alerte
define ("TEST_SRV",strstr($_ENV["SERVER_ADDR"],"192.168.0.")); // si serveur de dev/TEST local, affiche un message d'alerte
define('PATH2SHP2PGSQL_TEST', "/usr/local/pgsql/bin/pgsql2shp");
define('PATH2SHP2PGSQL_PROD', "/usr/lib/postgresql/8.0/bin/pgsql2shp");

/* --------------------------------------------------------------- */
session_start();

/* --------------------------------------------------------------- */
//error_reporting(E_ALL);
ini_set('register_globals','off');
ini_set('upload_tmp_dir','/tmp');
ini_set('error_prepend_string','<div class="phperror">');
ini_set('error_append_string','</div>');
if (get_magic_quotes_gpc()) {
  foreach($_REQUEST as $k=>$v) {
    if (!is_array($_REQUEST[$k])) $_REQUEST[$k] = stripslashes($v);
  } 
}
require_once (PROOT.'libs/etoil.lib.php');
//include_once(PROOT."/libs/conf.php");  deplac��la fin apr� la connexion db et la cr�tion de l'objet $db
include_once("fonctions.php");
include_once PROOT."/db/local.php";
$_SESSION['db_type']="pgsql";
$_SESSION['DBHost'] = $dbhost;
$_SESSION['DBName'] = $dbname;

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
$smarty->assign('language', $language);
$smarty->assign('langs', $langs);
$smarty->assign('url', basename($_SERVER['PHP_SELF']));
$smarty->assign('title', $title);

if (MSIE) {
	$smarty->assign('avertMSIE',true);
}

if (TEST_SRV) {
	$smarty->assign('avertTEST_SRV',true);
}

if (!empty($db)) {
	include_once (PROOT.'libs/psql.php');
	include_once(PROOT."libs/conf.php");
}
?>
