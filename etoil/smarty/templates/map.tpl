{include file="head.tpl"}

<script type="text/javascript" src="js/x_core_nn4.js"></script>
<script type="text/javascript" src="js/x_dom_nn4.js"></script>
<script type="text/javascript" src="js/x_event_nn4.js"></script>
<script type="text/javascript" src="js/navTools.js"></script>
<script type="text/javascript" src="js/graphTools.js"></script>
<form method="get" action="#nouveau_objet" name="carto_form">
<script type="text/javascript">
{literal}
var dhtmlDivs = new String();
document.image = new Image;
document.image.src = \''.$fichier.'\';

if (xIE) {
	dhtmlDivs = \'<div id="mapImageDiv" class="dhtmldiv" style="background-image:url(\'; 
	dhtmlDivs += document.image.src;
	dhtmlDivs += \');visibility:hidden;background-repeat:no-repeat;"></div>\';
} else {
	dhtmlDivs = \'<div id="mapImageDiv" class="dhtmldiv" style="visibility:hidden"><img \';
	dhtmlDivs += \'src="\' + document.image.src + \'" alt="Main map" title="" \';
	dhtmlDivs += \'width="'.$width.'px" height="'.$height.'px" /></div>\';
	
}
dhtmlDivs += \'<div id="myCanvasDiv" class="dhtmldiv"></div>\';
dhtmlDivs += \'<div id="myCanvas2Div" class="dhtmldiv"></div>\';
dhtmlDivs += \'<div id="mainDHTMLDiv" class="dhtmldiv"></div>\';
dhtmlDivs += \'<div id="diplayContainerDiv" class="dhtmldiv">\';
dhtmlDivs += \'<table border="0" width="100%" cellspacing="0" cellpadding="0"><tr>\';
dhtmlDivs += \'<td width="50%"><div id="displayCoordsDiv" class="dhtmlDisplay"></div></td>\';
dhtmlDivs += \'<td align="right" width="50%"><div id="displayMeasureDiv" class="dhtmlDisplay"></div></td>\';
dhtmlDivs += \'</tr></table></div>\';
document.write(dhtmlDivs);

function dboxInit() {
	myform = document.forms[\'carto_form\'];
	dhtmlBox = new dhtmlBox();
			
	dhtmlBox.dispPos = \'bottom\';
	dhtmlBox.thickness = 2;
	dhtmlBox.cursorsize = 4;
	dhtmlBox.jitter = 10; // minimum size of a box dimension
	dhtmlBox.d2pts = 3;   // the distance between two points (measure tools);
	dhtmlBox.nbPts = 5;   // number of points for the last vertex
	
	dhtmlBox.mapHeight = '.$height.';
	dhtmlBox.boxx = 470000;
	dhtmlBox.boxy = 46300;
	dhtmlBox.pixel_size = 924.83333333334;
	dhtmlBox.dist_msg = \'Approx. distance: \';
	dhtmlBox.dist_unit = \' m.\';
	dhtmlBox.surf_msg = \'Approx. surface: \';
	dhtmlBox.surf_unit = \' m².\';
	dhtmlBox.coord_msg = \'Coords (m): \';
	dhtmlBox.initialize();
}
	
window.onload = function() {
	dboxInit();
	xHide(xGetElementById(\'mapAnchorDiv\')); 
}
{/literal}
</script>
<div class="central">
<table>
<tr><td>
<a
href=""><img src="img/dot1.png" width="{$b}" height="{$b}" border="0" /></a><a
href=""><img src="img/dot2.png" width="{$mw}" height="{$b}" border="0" /></a><a
href=""><img src="img/dot1.png" width="{$b}" height="{$b}" border="0" /></a><br /><a
href=""><img src="img/dot2.png" width="{$b}" height="{$mh}" border="0" /></a><iframe
src="zemap.php" width="{$mw}" height="{$mh}" border="0" frameborder="0"></iframe><a
href=""><img src="img/dot2.png" width="{$b}" height="{$mh}" border="0" /></a><br /><a
href=""><img src="img/dot1.png" width="{$b}" height="{$b}" border="0" /></a><a
href=""><img src="img/dot2.png" width="{$mw}" height="{$b}" border="0" /></a><a
href=""><img src="img/dot1.png" width="{$b}" height="{$b}" border="0" /></a><br /><a
href=""></a>
</td><td>
<input type="hidden" name="id_carte" value="'.$id_carte.'"/>
<input type="hidden" name="retour" value="'.$retour.'"/>
<input type="hidden" name="selection_type" />
<input type="hidden" name="selection_coords" />
<div id="mapAnchorDiv" style="position:relative; width:'.$width.'px; height:'.$height.'px;"> 
<table>
<tr><td align="center" valign="middle" width="'.$width.'px" height="'.$height.'px">
<div id="loadbar">Loading message</div>
</td></tr></table>
</div>

<input type="radio" name="tool" value="rectangle,submit,crossHair,zoom_in"  id="zoom_in" onclick="dhtmlBox.changeTool()" />
<label for="zoom_in">zoom in</label><br />
<input type="radio" name="tool" value="point,submit,crossHair,zoom_out"  id="zoom_out" onclick="dhtmlBox.changeTool()" />
<label for="zoom_out">zoom out</label><br />
<input type="radio" name="tool" value="pan,submit,move,pan"  id="pan" onclick="dhtmlBox.changeTool()" />
<label for="pan">pan</label><br />
<input type="radio" name="tool" value="rectangle,submit,help,query"  id="query" onclick="dhtmlBox.changeTool()" />
<label for="query">query</label><br />
<input type="radio" name="tool" value="point,submit,crossHair,point"   id="point" onclick="dhtmlBox.changeTool()" />
<label for="point">point submit</label><br />
<input type="radio" name="tool" value="line,submit,crossHair,line"   id="line" onclick="dhtmlBox.changeTool()" />
<label for="line">line submit</label><br />
<input type="radio" name="tool" value="polygon,submit,crossHair,polygon"   checked="checked"  id="polygon" onclick="dhtmlBox.changeTool()" />
<label for="polygon">polygon submit</label><br />

</td></tr></table>
</div>
</form>

{include file="foot.tpl"}
