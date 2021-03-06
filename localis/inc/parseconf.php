<?  /* $Id: parseconf.php,v 1.3 2003/03/26 22:27:26 mose Exp $
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

function parseconf($file,$ar='') {
  if (is_file($file)) {
    $f = file($file);
		if (is_array($ar)) {
			$back = $ar;
		} else {
			$back = array();
		}
    foreach ($f as $line) {
			$g = ereg("\[(.*)\]",$l,$s);
			if ($g) $section = strtolower($s[1]);
      $l = trim($line).'#';
      if (trim($line) and (substr($l,0,1) != '#')) {
        $right = trim(strtok($l,'='));
        $left = trim(strtok('#'));
        if ($right and $left) {
          $back[$section][$right] = $left;
        }
      }
    }
    return $back;
  } else {
    return false;
  }
}
?>
