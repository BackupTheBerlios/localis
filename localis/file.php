<? /* $Id: file.php,v 1.4 2003/03/26 22:27:26 mose Exp $
Copyright (C) 2003, Makina Source, http://makina-source.org
This file is a component of Localis - http://localis.org
Created by mose <mose@makina-source.org> and mastre <mastre@localis.org>
Maintained by Makina Source <localis@makina-source.org>

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to 
the Free Software Foundation, Inc., 
59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
or check http://www.gnu.org/copyleft/gpl.html
*/

$id = $HTTP_GET_VARS['id'];
$table = $HTTP_GET_VARS['table'];

include "inc/parseconf.php";
include "inc/lib.php";

if (!is_file('etc/localis.conf')) die("etc/localis.conf not found<br>You need to copy etc/localis.conf.dist and modify it to fit your needs.");
$conf = parseconf('etc/localis.conf');
$conn = sig_connect();


if ($id and $table) {
	$user = getinfos($table,$id);
}

echo inc("head");
if (!$table) {
	echo "no table selected. please try again, tenderfoot.";
}
echo "<table class=dashed><tr><td><table border=0>";
if (is_array($user)) {
next($user);
echo "<tr><td colspan=2><div class=localis>$table</div></td></tR>";
while (list($k,$v) = each($user)) {
	echo "<tr><td><div class=foot>$k</div></td><td><div class=menu>$v</div></td></tR>";
	next($user);
}
} else {
	echo "<tr><td><div class=foot>id $id in table $table ? pff</div></td></tR>";
}
echo "</table></td></tr></table>\n";
echo inc("foot");
if (0 or $conf[gui][debug]) { echo "<pre style=font-size:80%;color:#990000>";print_r(get_defined_vars());echo "</pre>"; }
?>
