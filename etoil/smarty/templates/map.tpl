{include file="head.tpl"}
{popup_init src="js/overlib.js"}

<div class="central">
<form name="f">
<input type="hidden" name="extent" value="{$extent}" />
<table border="0" cellpadding="0" cellspacing="0">
<tr><td width="{math equation="(x * 2) + y + 2" x=$mapmargin y=$sizex}">
<map name="localisation" id="localisation">
{$maplocations}
</map>
<input type="image" src="img/dot1.png" width="1" height="1" border="0" name="dir" value="cc" />
<table cellspacing="0" cellpadding="0" border="0"><tr>
<td width="{$mapmargin}"><input type="image" src="img/dot1.png" width="{$mapmargin}" height="{$mapmargin}" border="0" name="dir" value="lt" /></td>
<td width="{$sizex+2}"><input type="image" src="img/dot2.png" width="{$sizex+2}" height="{$mapmargin}" border="0" name="dir" value="ct" /></td>
<td width="{$mapmargin}"><input type="image" src="img/dot1.png" width="{$mapmargin}" height="{$mapmargin}" border="0" name="dir" value="rt" /></td>
</tr><tr>
<td><input type="image" src="img/dot2.png" width="{$mapmargin}" height="{$sizey+2}" border="0" name="dir" value="lc" /></td>
<td><input type="image" src="{$mapimage}" width="{$sizex}" height="{$sizey}" alt="" border="1" hspace="0" vspace="0" class="map" usemap="#localisation" valign="top"></td>
<td><input type="image" src="img/dot2.png" width="{$mapmargin}" height="{$sizey+2}" border="0" name="dir" value="rc" /></td>
</tr><tr>
<td><input type="image" src="img/dot1.png" width="{$mapmargin}" height="{$mapmargin}" border="0" name="dir" value="lb" /></td>
<td><input type="image" src="img/dot2.png" width="{$sizex+2}" height="{$mapmargin}" border="0" name="dir" value="cb" /></td>
<td><input type="image" src="img/dot1.png" width="{$mapmargin}" height="{$mapmargin}" border="0" name="dir" value="rb" /></td>
</tr></table>

<table cellpadding="0" cellspacing="0" border="0"><tr>
{foreach name=leg key=k item=i from=$legends}
{if $filtre.type eq $smarty.foreach.leg.iteration}
<td class="bar2" width="20" style="width:20px;"><img src="{$i}" width="20" height="18" hspace="0" vspace="0" border="0" alt="" /></td>
<td class="bar2"><b style="margin: 0 15px 0 3px;font-size:12px;">{$k}</b></td><td>&nbsp;</td>
{else}
<td width="20" style="width:20px;"><img src="{$i}" width="20" height="18" hspace="0" vspace="0" border="0" alt="" /></td>
<td><a href="#" onclick="document.getElementById('ftype').value='{$smarty.foreach.leg.iteration}'; document.f.submit();" class="leg">{$k}</a></td><td>&nbsp;</td>
{/if}
{/foreach}
</tr></table>
<div class="foot" style="margin-left:10px;" id="light">Echelle: {$scale} {if $smarty.session.admin and $map_click}[x {$map_click.x} - y {$map_click.y} ]{/if}
</div>
<div class="foot" style="margin-top:10px;margin-bottom:2px;margin-left:10px;"><a href="{$mapimage}" target="_new" class="submit">{tr}Télécharger{/tr}</a></div>

</td>
<td style="padding-left : 10px;">

<div class="bar">Recherche de ville</div>
<input type="text" name="ville" value="" style="width:100%;" /><br />
{if $cities}
<div class="found">
{section name=o loop=$cities}
{$cities[o].code_postal}
<a href="{$url}?focusville={$cities[o].nom|escape:"url"}">{$cities[o].nom}</a><br />
{/section}
</div>
{elseif $city_info}
<div class="found">
{$city_info[0].code_postal}
{$city_info[0].nom}
</div>
{/if}

<table border="0" cellpadding="1" cellspacing="0" id="map">
<tr><td valign="top" align="center">
<input type="image" src="{$refsrc}" width="100" height="100" name="ref" alt="{$name}" hspace="0" vspace="0" border="0"><img 
src="img/francepti.jpg" width="100" height="100" border="0" />
<br />

<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td valign="middle">
<select name="size" class="submit" id="100" onchange="document.f.resize.value='y' ; document.f.submit();">
<option value="240x240"{$sizecheck.240x240}>240x240</option>
<option value="400x400"{$sizecheck.400x400}>400x400</option>
<option value="600x600"{$sizecheck.600x600}>600x600</option>
<option value="800x800"{$sizecheck.800x800}>800x800</option>
</select>
<input type="image" src="img/expand.png" width="16" height="11" name="fit" value="{tr}Recadrer{/tr}" class="submit" onclick="document.f.extent.value=''; document.f.submit();"
{popup text="{tr}Recadrer{/tr} [ Alt-c ]"} accesskey="c" />
</td>
</tr></table>
</td></tr></table>
<input type="hidden" name="resize" value="n" />

<table border="0" cellpadding="2" cellspacing="1" width="100%" class="navbar">
<tr>
{if $smarty.session.admin}
<td valign="top" width="25%" align="center" class="tool{$focus.edit}" id='tool_edit'>
<div {popup text="{tr}Ajouter{/tr} [ Alt-a ]"}><label for="edit" accesskey="a"><img src="img/edit.png" width="20" height="20" hspace="0" vspace="0" border="0" alt="Edit" valign="top"></label>
<input type="radio" id="edit" name="action" value="edit"{if $focus.edit eq 'focus'} checked="checked"{/if} onchange="toggletool('tool_edit');"/></div></td>
{/if}
<td valign="top" width="25%" align="center" class="tool{$focus.zoomout}" id='tool_zoomout'>
<div {popup text="{tr}Eloigner{/tr} [ Alt-e ]"}><label for="zoomout" accesskey="e"><img src="img/zoomout2.png" width="20" height="20" hspace="0" vspace="0" border="0" alt="Zoom Arrière" valign="top"></label>
<input type="radio" id="zoomout" name="action" value="zoomout"{if $focus.zoomout eq 'focus'} checked="checked"{/if} onchange="toggletool('tool_zoomout')" /></div></td>
<td valign="top" width="25%" align="center" class="tool{$focus.travel}" id='tool_travel'>
<div {popup text="{tr}Déplacer{/tr} [ Alt-d ]"}><label for="travel" accesskey="d"><img src="img/travel.png" width="20" height="20" hspace="0" vspace="0" border="0" alt="Déplacement" valign="top"></label>
<input type="radio" id="travel" name="action" value="travel"{if $focus.travel eq 'focus'} checked="checked"{/if} onchange="toggletool('tool_travel')" /></div></tD>
<td valign="top" width="25%" align="center" class="tool{$focus.zoomin}" id='tool_zoomin'>
<div {popup text="{tr}Rapprocher{/tr} [ Alt-r ]"}><label for="zoomin" accesskey="r"><img src="img/zoomin2.png" width="20" height="20" hspace="0" vspace="0" border="0" alt="Zoom avant" valign="top"></label>
<input type="radio" id="zoomin" name="action" value="zoomin"{if $focus.zoomin eq 'focus'} checked="checked"{/if} onchange="toggletool('tool_zoomin')" /></div></td>
</td></tr></table>

<div class="bar">Selection</div>
<div class="selection">
<select name="filtre[type]" id="ftype">
<option value="">{tr}Moyen de locomotion{/tr}</option>
<option value="">{tr}... Indifférent{/tr}</option>
{foreach key=k item=i from=$types}
<option value="{$k}"{if $filtre.type eq $k} selected="selected"{/if}>{$i}</option>
{/foreach}
</select><br />

<select name="filtre[time]">
<option value="">{tr}Durée du parcours{/tr}</option>
<option value="">{tr}... Indifférent{/tr}</option>
{foreach key=k item=i from=$times}
<option value="{$k}"{if $filtre.time eq $k} selected="selected"{/if}>{$i}</option>
{/foreach}
</select><br />

<select name="filtre[level]">
<option value="">{tr}Niveau de difficulté{/tr}</option>
<option value="">{tr}... Indifférent{/tr}</option>
{foreach key=k item=i from=$levels}
<option value="{$k}"{if $filtre.level eq $k} selected="selected"{/if}>{$i}</option>
{/foreach}
</select><br />

<input type="submit" name="action" value="{tr}Rechercher{/tr}" /><br />
</div>

<div class="bar">
{section name=t loop=$tracks}
{assign var=v value=$tracks[t].parcours_type}
<img src="{$icontypes.$v}" width="10" height="9" /> {$tracks[t].parcours_name}<br />
{/section}
</div>


{if $smarty.session.admin}
{if $smarty.request.do eq "{tr}Enregistrer{/tr}"}
<div class="bar">{tr}Edition/ajout de tracé{/tr}</div>
<table class="inputable">
<tr><td>Nom</td><td><input type="text" name="p_name" value="" /></td></tr>
<tr><td>Moyen de locomotion</td><td>
<select name="p_type">
{foreach key=k item=i from=$types}
<option value="{$k}"{if $filtre.type eq $k} selected="selected"{/if}>{$i}</option>
{/foreach}
</select></td></tr>

<tr><td>Duree</td><td>
<select name="p_time">
{foreach key=k item=i from=$times}
<option value="{$k}"{if $filtre.time eq $k} selected="selected"{/if}>{$i}</option>
{/foreach}
</select></td></tr>

<tr><td>Difficulté (1 facile, 5 tres dur)</td><td>
<select name="p_level">
{foreach key=k item=i from=$levels}
<option value="{$k}"{if $filtre.level eq $k} selected="selected"{/if}>{$i}</option>
{/foreach}
</select></td></tr>
<tr><td></td><td><input type="submit" name="action" value="Enregistrer" /></td></tr>
</table>
{/if}
{if count($smarty.session.track)}
<div class="bar">{tr}Coordonnées du tracé{/tr}</div>
{if $smarty.request.do ne "{tr}Enregistrer{/tr}"}
<div class="dashed">
<input type="submit" name="do" value="{tr}Effacer{/tr}" />
<input type="submit" name="do" value="{tr}Enregistrer{/tr}" /></div>
{/if}
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
