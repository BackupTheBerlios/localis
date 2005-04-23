<?php
$title = "Accueil";
include("setup.php");

if (isset($_REQUEST['loggedok'])) {
	$feedback[] = array('num'=>1,'msg'=>tra("Vous êtes maintenant identifié"));
}
// sur le proto, on n'affiche la carte que si on est loggé avec un profil >=1 et que le code profil
$bool_map_disp=(!empty($_SESSION['me']) && $_SESSION['profile']>=1 ) || $anonym_disp_maps;
$smarty->assign('bool_map_disp',$bool_map_disp);

$smarty->display("home.tpl");
echo elapsed_time();
?>
