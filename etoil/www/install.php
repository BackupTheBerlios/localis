<?php
$title = "Installation";
include("setup.php");
$bad = false;
if (!function_exists("pg_connect")) {
	$mes[] = array(-1,"php-pgsql extension not installed.");
	$mes[] = array(0,"-- maybe you need to add 'extension=psql.so' in your php.ini");
	$bad = true;
} else {
	$mes[] = array(1,"php-pgsql extension found.");
}
if (is_file(PROOT."libs/local.php")) {
	$mes[] = array(1,"conf file found ".PROOT."libs/local.php found.");
} else {
	$mes[] = array(-1,"conf file ".PROOT."libs/local.php not found.");
	$mes[] = array(0,"-- Please create it manually by copying ".PROOT."libs/local-dist.php");
	$bad = true;
}
if (!$bad) {
	include PROOT."libs/psql.php";
}
$smarty->assign('mes',$mes);
$smarty->display("install.tpl");
?>
