<?php
$title = "Gestion des Variables de configuration";
$db = true;
$mod = false;
$feedback = $focus = array();
include("setup.php");

if (isset($_REQUEST['newconflines'])) {
	$lines = split("\n",$_REQUEST['newconflines']);
	foreach ($lines as $l) {
		$u = split(',',$l);
		if (count($u) == 2) {
			if (!$db->mod_conf($u[0],$u[1])) {
				$feedback[] = array('num'=>-1,'msg'=>$db->mes[0]);
			}
		} else {
			$feedback[] = array('num'=>-1,'msg'=>"Ligne incorrecte: <br /><b>$l</b>");
		}
	}
} elseif (isset($_REQUEST['del'])) {
	if (isset($_POST['confirm'])) {
		if ($db->del_conf($_POST['del'])) {
			$feedback[] = array('num'=>1,'msg'=>sprintf('Conf line <u>%s</u> deleted.',$_POST['del']));
		}
	} else {
		$smarty->assign('item',tra('conf'));
		$smarty->assign('url','admin-conf.php');
		$smarty->assign('params',array('del'=>$_REQUEST['del'],'confirm'=>'1'));
		$feedback[] = array('num'=>0,'msg'=>$smarty->fetch('confirm_delete.tpl'));
	}
} elseif (isset($_REQUEST['mod'])) {
	if (isset($_POST['save']) and isset($_REQUEST['f']['name'])) {
		$f = $_REQUEST['f'];
		if ($db->mod_conf($f['name'],$f['value'])) {
			$feedback[] = array('num'=>1,'msg'=>sprintf("Conf <u>%s</u> modifié",$f['name']));
		} else {
			$feedback[] = array('num'=>-1,'msg'=>$db->mes[0]);
		}
	} else {
		$mod = true;
		$focus = $db->get_conf($_REQUEST['mod']);
	}
} elseif (isset($_REQUEST['f']['name']) and isset($_REQUEST['f']['value'])) {
	$f = $_REQUEST['f'];
	if ($db->mod_conf($f['name'],$f['value'])) {
		$feedback[] = array('num'=>1,'msg'=>sprintf("Conf <u>%s</u> ajouté",$f['name']));
	} else {
		$feedback[] = array('num'=>-1,'msg'=>$db->mes[0]);
	}
}

$confs = $db->list_confs();

$smarty->assign('mod',$mod);
$smarty->assign('focus',$focus);
$smarty->assign('confs',$confs);
$smarty->display("admin-conf.tpl");
?>
