<?php

define('SMARTY_DIR', '../smarty/');

require_once ( SMARTY_DIR.'Smarty.class.php');

class Smarty_Etoil extends Smarty {
  function Smarty_Etoil() {
    $this->template_dir = SMARTY_DIR.'templates/';
    $this->compile_dir = SMARTY_DIR."temp/";
    $this->config_dir = SMARTY_DIR."configs/";
    $this->cache_dir = SMARTY_DIR."temp/";
    $this->caching = 0;
    $this->assign('app_name', 'E-Toil');
    $this->plugins_dir = array(SMARTY_DIR."extra/",SMARTY_DIR."plugins/");
    $this->use_sub_dirs = false;
  }

	function _smarty_include($params) {
		global $language;
		$langfile = substr($_smarty_tpl_file,0,-4).'.'.$language.'.tpl';
		if (is_file($this->template_dir."/".$langfile)) {
			$params['smarty_include_tpl_file'] = $langfile;
		}
		return parent::_smarty_include($params);
	}

  function fetch($_smarty_tpl_file, $_smarty_cache_id = null, $_smarty_compile_id = null, $_smarty_display = false) {
		global $language;
		$langfile = substr($_smarty_tpl_file,0,-4).'.'.$language.'.tpl';
		if (is_file($this->template_dir."/".$langfile)) {
			$_smarty_tpl_file = $langfile;
		}
		$_smarty_cache_id = $language . $_smarty_cache_id;
		$_smarty_compile_id = $language . $_smarty_compile_id;
		return parent::fetch($_smarty_tpl_file, $_smarty_cache_id, $_smarty_compile_id, $_smarty_display);
	}

}

$smarty = new Smarty_Etoil();
$smarty->load_filter('pre', 'tr');
?>
