<?php
$title = "Nouveau compte";
$f = array();
$db = true;
include("setup.php");

if (isset($_POST['login']) and isset($_POST['pass1']) and isset($_POST['pass2'])) {
	if ($_POST['pass1'] != $_POST['pass2']) {
		$feedback[] = array('num'=>-1,'msg'=>tra("Votre repetition de mot de pass differe."));
		$f = $_POST;
	} else {
		if (!isset($_POST['email'])) $_POST['email'] = '';
		if (!isset($_POST['bio'])) $_POST['bio'] = '';
		if ($db->add_user($_POST['login'],$_POST['pass1'],$_POST['email'],$_POST['bio'],0)) {
			header('Location: /login.php?msg=welcome');
			exit;
		} else {
			$feedback[] = array('num'=>-1,'msg'=>$db->mes[0]);
		}
	}
}

$smarty->assign('f',$f);
$smarty->display("register.tpl");
?>
