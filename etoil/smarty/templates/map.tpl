{include file="head.tpl"}

<div class="central">
<form name="f">
<input type="hidden" name="extent" value="{$extent}" />
<table border="0" cellpadding="0" cellspacing="0">
<tr><td width="{math equation="(x * 2) + y + 2" x=$mapmargin y=$sizex}">
<map name="localisation" id="localisation">
{$maplocations}
</map>
<table cellspacing="0" cellpadding="0" border="0"><tr>
<td width="{$mapmargin}"><input type="image" src="img/dot1.png" width="{$mapmargin}" height="{$mapmargin}" border="0" name="dir" value="rt" /></td>
<td width="{$sizex+2}"><input type="image" src="img/dot2.png" width="{$sizex+2}" height="{$mapmargin}" border="0" name="dir" value="ct" /></td>
<td width="{$mapmargin}"><input type="image" src="img/dot1.png" width="{$mapmargin}" height="{$mapmargin}" border="0" name="dir" value="lt" /></td>
</tr><tr>
<td><input type="image" src="img/dot2.png" width="{$mapmargin}" height="{$sizey+2}" border="0" name="dir" value="lc" /></td>
<td><input type="image" src="{$mapimage}" width="{$sizex}" height="{$sizey}" alt="" border="1" hspace="0" vspace="0" class="map" usemap="#localisation" valign="top"></td>
<td><input type="image" src="img/dot2.png" width="{$mapmargin}" height="{$sizey+2}" border="0" name="dir" value="rc" /></td>
</tr><tr>
<td><input type="image" src="img/dot1.png" width="{$mapmargin}" height="{$mapmargin}" border="0" name="dir" value="lb" /></td>
<td><input type="image" src="img/dot2.png" width="{$sizex+2}" height="{$mapmargin}" border="0" name="dir" value="cb" /></td>
<td><input type="image" src="img/dot1.png" width="{$mapmargin}" height="{$mapmargin}" border="0" name="dir" value="rb" /></td>
</tr></table>

<img src="{$legsrc}" border="1" alt="legende" align="right" hspace="9" vspace="4">
<div class="foot" style="margin-left:10px;" id="light">{$mapscale} {$scale} {$mapscaleunit}</div>
<div class="foot" style="margin-top:10px;margin-bottom:2px;margin-left:10px;"><a href="{$mapimage}" target="_new" class="submit">{tr}Télécharger{/tr}</a></div>

</td>
<td>

<table border="0" cellpadding="1" cellspacing="0" class="dashed" id="map">
<tr><td valign="top" align="center">
<input type="image" src="{$refsrc}" width="100" height="100" name="ref" alt="{$name}" hspace="0" vspace="0" border="0"><br>
<input type="submit" name="fit" value="{tr}Recadrer{/tr}" class="submit" onclick="document.f.forceextent.value='1'; document.f.extent.value=''; document.f.scale.value=''; document.f.submit();">

<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td valign="middle"><select name="size" class="submit" id="100">
<option value="240x240"{$sizecheck.240x240}>240x240</option>
<option value="400x400"{$sizecheck.400x400}>400x400</option>
<option value="600x600"{$sizecheck.600x600}>600x600</option>
<option value="800x800"{$sizecheck.800x800}>800x800</option>
</select></td>
<td align="right" valign="middle">
<div><input type="submit" name="resize" value="&gt;&gt;" class="submit" id="100"></div>
</td></tr></table>
</td></tr></table>

<table border="0" cellpadding="2" cellspacing="1" width="100%" class="dashed">
<tr>
{if $smarty.session.admin}
<td valign="top" width="25%" align="center" class="tool{$focus.edit}" id='tool_edit'>
<div><label for="edit"><img src="img/edit.png" width="20" height="20" hspace="0" vspace="0" border="0" alt="Edit" valign="top"></label><br />
<input type="radio" id="edit" name="action" value="edit"{if $focus.edit eq 'focus'} checked="checked"{/if} accesskey="r" onchange="toggletool('tool_edit');" /></div></td>
{/if}
<td valign="top" width="25%" align="center" class="tool{$focus.zoomout}" id='tool_zoomout'>
<div><label for="zoomout"><img src="img/zoomout2.png" width="20" height="20" hspace="0" vspace="0" border="0" alt="Zoom Arrière" valign="top"></label><br />
<input type="radio" id="zoomout" name="action" value="zoomout"{if $focus.zoomout eq 'focus'} checked="checked"{/if} accesskey="a" onchange="toggletool('tool_zoomout')" /></div></td>
<td valign="top" width="25%" align="center" class="tool{$focus.travel}" id='tool_travel'>
<div><label for="travel"><img src="img/travel.png" width="20" height="20" hspace="0" vspace="0" border="0" alt="Déplacement" valign="top"></label><br />
<input type="radio" id="travel" name="action" value="travel"{if $focus.travel eq 'focus'} checked="checked"{/if} accesskey="z" onchange="toggletool('tool_travel')" /></div></tD>
<td valign="top" width="25%" align="center" class="tool{$focus.zoomin}" id='tool_zoomin'>
<div><label for="zoomin"><img src="img/zoomin2.png" width="20" height="20" hspace="0" vspace="0" border="0" alt="Zoom avant" valign="top"></lable><br />
<input type="radio" id="zoomin" name="action" value="zoomin"{if $focus.zoomin eq 'focus'} checked="checked"{/if}  accesskey="e" onchange="toggletool('tool_zoomin')" /></div></td>
</td></tr></table>

<table border="0" cellpadding="4" cellspacing="0" width="100%" class="dashed">
<tr><td valign="top">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
{$layermenu}</table>
<input type="submit" name="refresh" value="{tr}Rafraichir{/tr}" class="submit" id="106" />
</td></tr></table>

<div class="bar">Selection</div>
<select name="filtre[moyen]">
<option value="">{tr}Moyen de locomotion{/tr}</option>
<option value="">{tr}... Indifférent{/tr}</option>
{foreach key=k item=i from=$moyens}
<option value="{$k}"{if $filtre.moyen eq $k} selected="selected"{/if}>{$i}</option>
{/foreach}
</select><br />

<select name="filtre[duree]">
<option value="">{tr}Durée du parcours{/tr}</option>
<option value="">{tr}... Indifférent{/tr}</option>
{foreach key=k item=i from=$durees}
<option value="{$k}"{if $filtre.duree eq $k} selected="selected"{/if}>{$i}</option>
{/foreach}
</select><br />

<select name="filtre[difficulte]">
<option value="">{tr}Niveau de difficulté{/tr}</option>
<option value="">{tr}... Indifférent{/tr}</option>
{foreach key=k item=i from=$difficultes}
<option value="{$k}"{if $filtre.difficulte eq $k} selected="selected"{/if}>{$i}</option>
{/foreach}
</select><br />

<input type="submit" name="action" value="{tr}Rechercher{/tr}" /><br />

{if $smarty.request.save eq 'all'}
<table border="1">
<tr><td>Nom</td><td><input type="text" name="p_name" value="" /></td></tr>
<tr><td>Moyen de locomotion</td><td><select name="p_type">
{foreach key=k item=i from=$moyens}
<option value="{$k}">{$i}</option>
{/foreach}
</select></td></tr>

<tr><td>Duree</td><td>
<select name="p_duree">
{foreach key=k item=i from=$durees}
<option value="{$k}">{$i}</option>
{/foreach}
</select></td></tr>

<tr><td>Difficulté (1 facile, 5 tres dur)</td><td>
<select name="p_difficulte">
{foreach key=k item=i from=$difficultes}
<option value="{$k}">{$i}</option>
{/foreach}
</select></td></tr>
<tr><td></td><td><input type="submit" name="action" value="Enregistrer" /></td></tr>
</table>
{/if}
{if $smarty.session.admin}
click x : {$map_click.x}<br />
click y : {$map_click.y}<br />
<hr />
{if count($smarty.session.track)}
<div class="dashed">
<a href="{$url}?purge=all">purge</a>
<a href="{$url}?save=all">save</a></div>
{foreach item=x from=$smarty.session.track}
<a href="{$url}?del={$x|escape:"url"}">[x]</a> <a href="">{$x}</a><br />
{/foreach}
<hr />
{/if}
{/if}
</td></tr></table>
</form>
</div>

{include file="foot.tpl"}
