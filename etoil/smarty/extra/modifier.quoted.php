<?php

//this script may only be included - so its better to die if called directly.
if (strpos($_SERVER["SCRIPT_NAME"],basename(__FILE__)) !== false) {
  header("location: index.php");
  exit;
}

/*
 * Smarty plugin
 * -------------------------------------------------------------
 * Type:     modifier
 * Name:     spacify
 * Purpose:  add spaces between characters in a string
 * -------------------------------------------------------------
 */
function smarty_modifier_quoted($string)
{
    $string = str_replace("\n","\n>",$string);
    return '>'.$string;
}

/* vim: set expandtab: */

?>
