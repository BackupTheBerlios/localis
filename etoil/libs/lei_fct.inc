<?php
/* Fonctions acces LEI
*/
class lei_acc {
	var $tbselcats=array() ;
	
function ret_tb_cat_lei() {
	
	global $db;
	$i=0;
	$rpr=$db->s_query("SELECT * from lei_categ");
	$toto=array();
	while ($rp=db_fetch_array($rpr))
		{
		$str_ret.= "Tree[$i] = \"".$rp['lei_cat_id']."|".($rp['lei_cat_id']!=$rp['lei_cat_pid'] ? $rp[lei_cat_pid]: "")."|".$rp[lei_cat_libelle]."||".($rp[lei_cat_symb]!="" ? $rp[lei_cat_symb]: "")."|".($_REQUEST['layer_'.$rp['lei_cat_id']]=='Y' ? "checked" : "")."|".($_REQUEST['opennode_'.$rp['lei_cat_id']]=='true' ? "open" : "closed")."||\";\n";
		$i++;
		if ($_REQUEST['layer_'.$rp['lei_cat_id']]=='Y') { 
			
			$this->tbselcats[]=$rp['lei_cat_id'];
			//echo "coucu".$rp['lei_cat_id'];
			}
		}
		print_r($this->tbselcats);
	return($str_ret);
  }
}
?>
