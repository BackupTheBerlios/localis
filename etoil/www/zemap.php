<?php 
$title = "zemap";
include("setup.php");
checkfontlist(PROOT."/maps");

$smarty->display("zemap.tpl");
?>
