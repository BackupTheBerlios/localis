<?php
include("setup.php");
if (isset($_SERVER['HTTP_REFERER'])) {
	$to = $_SERVER['HTTP_REFERER'];
} elseif (isset($_REQUEST['from'])) {
	$to = $_REQUEST['from'];
} else {
	$to = "index.php";
}
$smarty->clear_compiled_tpl();
header('Location: '. $to);
?>
