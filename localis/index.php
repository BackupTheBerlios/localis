<? /* $Id: index.php,v 1.3 2002/10/28 04:05:57 mose Exp $
Copyright (C) 2002, Makina Corpus, http://makina-corpus.org
This file is a component of Localis <http://localis.makina-corpus.org>
Created by mose@makina-corpus.org and mastre@makina-corpus.org
Maintained by Makina Corpus <localis@makina-corpus.org>

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307,
USA.
*/
include "inc/parseconf.php";
include "inc/lib.php";

if (!is_file('etc/localis.conf')) die("localis.conf not found<br>Maybe you need to copy localis.conf.dist");

$conn = sig_connect();
$preconf = parseconf('etc/localis.conf');
if ($HTTP_GET_VARS['lang']) {
  $lang   = $HTTP_GET_VARS['lang'];
	$qlang  = "&lang=$lang";
	$ilang  = "<input type=hidden name=lang value=$lang>";
} else {
	$lang = $preconf["general"]["lang"];
}
$loc_conf = $preconf["general"]["tpl_path"]."/".$lang."/lang.conf";
if (is_file($loc_conf)) {
  $conf = parseconf($loc_conf,$preconf);
} else {
  $conf = $preconf;
  $lang = $conf["general"]["lang"];
}
foreach ($conf[form] as $field=>$f) {
	${"$field"}    = $HTTP_GET_VARS["$field"];
	${"list_$field"} = sig_list($f,$conn,0);
	${"menu_$field"} = domenu(${"list_$field"},$$field);
}

mysql_close($conn);
echo inc("head");
echo inc("search");
if ($_GET[help]) {
	echo inc("help");
} elseif ($_GET[credits]) {
	echo inc("credits");
} else { 
	echo inc("index");
}
echo inc("foot");
?>
