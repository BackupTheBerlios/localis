<?php
$title = "Accueil";
include("setup.php");

if (isset($_REQUEST['loggedok'])) {
	$feedback[] = array('num'=>1,'msg'=>tra("Vous �tes maintenant identifi�"));
}

$smarty->display("home.tpl");
echo elapsed_time();
?>
