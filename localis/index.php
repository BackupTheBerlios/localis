<? /* $Id: index.php,v 1.5 2003/02/03 08:28:44 mose Exp $
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

$conf = parseconf('etc/localis.conf');

$page = ($HTTP_GET_VARS['page']) ? $HTTP_GET_VARS['page'] : 'index';
$lang = ($HTTP_GET_VARS['lang']) ? $HTTP_GET_VARS['lang'] : $conf['general']['lang'];
$mode = ($HTTP_GET_VARS['mode']) ? $HTTP_GET_VARS['mode'] : $conf['general']['mode'];

if ($HTTP_GET_VARS['lang']) {
	$glob['query'].= "&lang=$lang";
	$glob['input'].= "<input type=\"hidden\" name=\"lang\" value=\"$lang\">";
}

if ($HTTP_GET_VARS['mode']) {
	$glob['query'].= "&mode=$mode";
	$glob['input'].= "<input type=\"hidden\" name=\"mode\" value=\"$mode\">";
}

$tpl_path = $conf[general][tpl_path]."/$mode";

if (is_file("$tpl_path/$lang/globals.php")) {
	include "$tpl_path/$lang/globals.php";
}

$glob["lang$lang"] = "selected";

echo inc("head");
echo inc("search");
echo inc("$page");
echo inc("foot");
?>
