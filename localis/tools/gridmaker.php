<? /*
$Id: gridmaker.php,v 1.2 2003/03/26 22:27:26 mose Exp $
-------------------
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

/*
// just uncomment the code for it works

// Load MapScript
dl("php_mapscript.so");

// the name of output file
$shpFname = "maps/data/grid1km";

// extent = $startx, $starty, $startx + $span, $starty + $span
$startx =  226500;
$starty = 1745500;
$span   =  400000;
$lines  =  400;
$gridsp =  1000;


// then there is code. you shouldn't have to change anything below

if (is_file("$shpFname.shx")) {
unlink("$shpFname.dbf");
unlink("$shpFname.shx");
unlink("$shpFname.shp");
}
$shpFile = ms_newShapeFileObj( $shpFname, MS_SHP_ARC);
$dbfFile = dbase_create( $shpFname.".dbf", array(array("GRID_ID", "N", 10, 0)));

for ($i=0;$i<$lines;$i++) {

    $oShp = ms_newShapeObj(MS_SHP_LINE);

    $oLine = ms_newLineObj();
    $oLine->addXY($startx,       $starty+($gridsp*$i));
    $oLine->addXY($startx+$span, $starty+($gridsp*$i));
    $oShp->add( $oLine );
		$oLine->free();

    $shpFile->addShape($oShp);

    dbase_add_record($dbfFile, array(10000+$i));
		$oShp->free();
}

for ($i=0;$i<$lines;$i++) {

    $oShp = ms_newShapeObj(MS_SHP_LINE);

    $oLine = ms_newLineObj();
    $oLine->addXY($startx+($gridsp*$i), $starty);
    $oLine->addXY($startx+($gridsp*$i), $starty+$span);
    $oShp->add( $oLine );
		$oLine->free();

    $shpFile->addShape($oShp);

    // Write attribute record
    dbase_add_record($dbfFile, array(20000+$i));
}

echo "Shapes Created.<BR>";

//----------------------------------------------------------
// done... cleanup
//----------------------------------------------------------

$shpFile->free();
echo "Shape File ($shpFname) closed.<BR>";

echo "Dbase file closed.<BR>";
dbase_close($dbfFile);
*/
echo "edit and READ that file.";
?>

