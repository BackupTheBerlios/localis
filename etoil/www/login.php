<?php
$title = 'Entrer';
$db = true;
include("setup.php");

if (isset($_SESSION['me'])) {
  header('Location: index.php?alreadylogged=1'); exit;
} elseif (isset($_POST['login']) and isset($_POST['pass'])) {
	$error = $db->errorlogin($_POST['login'], $_POST['pass']);
	if ($error) {
		$smarty->assign('login', $_POST['login']);
		$feedback[] = array('num'=>'-1','msg'=>$error);
	} else {
  	header('Location: index.php?loggedok=1'); exit;
	}
}
if (isset($_REQUEST['msg'])) {
	$smarty->assign('msg',$_REQUEST['msg']);
}

$smarty->display("login.tpl");
?>
