<?php
$title = "Gestion des utilisateurs";
$db = true;
$mod = false;
$feedback = $focus = array();
include("setup.php");

if (isset($_REQUEST['newusers'])) {
	$lines = split("\n",$_REQUEST['newusers']);
	foreach ($lines as $l) {
		$u = split(',',$l);
		if (count($u) == 4) {
			if (!$db->add_user($u[0],$u[1],$u[2],$u[3])) {
				$feedback[] = array('num'=>-1,'msg'=>$db->mes[0]);
			}
		} else {
			$feedback[] = array('num'=>-1,'msg'=>"Ligne incorrecte: <br /><b>$l</b>");
		}
	}
} elseif (isset($_REQUEST['del'])) {
	if (isset($_POST['confirm'])) {
		if ($db->del_user($_POST['del'])) {
			$feedback[] = array('num'=>1,'msg'=>sprintf('User <u>%s</u> deleted.',$_POST['del']));
		}
	} else {
		$smarty->assign('item',tra('utilisateur'));
		$smarty->assign('url','admin-users.php');
		$smarty->assign('params',array('del'=>$_REQUEST['del'],'confirm'=>'1'));
		$feedback[] = array('num'=>0,'msg'=>$smarty->fetch('confirm_delete.tpl'));
	}
} elseif (isset($_REQUEST['mod'])) {
	if (isset($_POST['save']) and isset($_REQUEST['f']['login'])) {
		$f = $_REQUEST['f'];
		if ($db->mod_user($f['login'],$f['pass'],$f['email'],$f['bio'],$f['credential'])) {
			$feedback[] = array('num'=>1,'msg'=>sprintf("Utilisateur <u>%s</u> modifié",$f['login']));
		} else {
			$feedback[] = array('num'=>-1,'msg'=>$db->mes[0]);
		}
	} else {
		$mod = true;
		$focus = $db->get_user($_REQUEST['mod']);
	}
} elseif (isset($_REQUEST['f']['login']) and isset($_REQUEST['f']['pass']) and isset($_REQUEST['f']['email'])) {
	$f = $_REQUEST['f'];
	if (!$db->add_user($f['login'],$f['pass'],$f['email'],$f['bio'])) {
		$feedback[] = array('num'=>-1,'msg'=>$db->mes[0]);
	}
} elseif (isset($_REQUEST['adm'])) {
	if (!$db->change_credential($_REQUEST['adm'],1)) {
		$feedback[] = array('num'=>-1,'msg'=>$db->mes[0]);
	} else {
		$feedback[] = array('num'=>1,'msg'=>sprintf("Utilisateur <u>%s</u> modifié",$_REQUEST['adm']));
	}
} elseif (isset($_REQUEST['dem'])) {
	if (!$db->change_credential($_REQUEST['dem'],0)) {
		$feedback[] = array('num'=>-1,'msg'=>$db->mes[0]);
	} else {
		$feedback[] = array('num'=>1,'msg'=>sprintf("Utilisateur <u>%s</u> modifié",$_REQUEST['dem']));
	}
}

$users = $db->list_users();

$smarty->assign('mod',$mod);
$smarty->assign('focus',$focus);
$smarty->assign('users',$users);
$smarty->display("admin-users.tpl");
?>
