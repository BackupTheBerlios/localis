<?php
$title = 'Entrer';
include("setup.php");

unset($_SESSION['me']);
unset($_SESSION['profile']);
unset($_SESSION['admin']);
unset($_SESSION['track']); // annule la trace


if (isset($_REQUEST['from'])) {
	$exit = basename($_REQUEST['from']);
} else {
	$exit = 'index.php';
}
header("Location: $exit");
?>
