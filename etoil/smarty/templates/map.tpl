{include file="head.tpl"}

<div class="central">
<form name="f">
<input type="hidden" name="extent" value="{$extent}" />
<table border="0" cellpadding="0" cellspacing="0">
<tr><td>
<map name="localisation" id="localisation">
{$maplocations}
</map>
<input
type="image" src="img/dot1.png" width="{$mapmargin}" height="{$mapmargin}" border="0" /><input
type="image" src="img/dot2.png" width="{$sizex+2}" height="{$mapmargin}" border="0" /><input
type="image" src="img/dot1.png" width="{$mapmargin}" height="{$mapmargin}" border="0" /><br /><input
type="image" src="img/dot2.png" width="{$mapmargin}" height="{$sizey+2}" border="0" /><input
type="image" src="{$mapimage}" width="{$sizex}" height="{$sizey}" alt="" border="1" hspace="0" vspace="0" class="map" usemap="#localisation" valign="top"><input
type="image" src="img/dot2.png" width="{$mapmargin}" height="{$sizey+2}" border="0" /><br /><input
type="image" src="img/dot1.png" width="{$mapmargin}" height="{$mapmargin}" border="0" /><input
type="image" src="img/dot2.png" width="{$sizex+2}" height="{$mapmargin}" border="0" /><input
type="image" src="img/dot1.png" width="{$mapmargin}" height="{$mapmargin}" border="0" /><br />

<img src="{$legsrc}" border="1" alt="legende" align="right" hspace="9" vspace="4">
<div class="foot" style="margin-left:10px;" id="light">{$mapscale} {$scale} {$mapscaleunit}</div>
<div class="foot" style="margin-top:10px;margin-bottom:2px;margin-left:10px;"><a href="{$mapimage}" target="_new" class="submit">{tr}Télécharger{/tr}</a></div>

</td>
<td>

<table border="0" cellpadding="1" cellspacing="0" class="dashed" id="map">
<tr><td valign="top" align="center">
<input type="image" src="{$refsrc}" width="100" height="100" name="ref" alt="{$name}" hspace="0" vspace="0" border="0"><br>
<input type="submit" name="fit" value="{tr}Recadrer{/tr}" class="submit" id="106" onclick="document.f.forceextent.value='1'; document.f.extent.value=''; document.f.scale.value=''; document.f.submit();">

<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr><td valign="middle"><select name="size" class="submit" id="100">
<option value="320x240"{$sizecheck.320x240}>320x240</option>
<option value="640x480"{$sizecheck.640x480}>640x480</option>
<option value="800x600"{$sizecheck.800x600}>800x600</option>
<option value="1024x768" style="border-bottom: 1px solid #000000;"{$sizecheck.1024x768}>1024x768</option>
<option value="240x120"{$sizecheck.240x120}>240x120</option>
<option value="400x200"{$sizecheck.400x200}>400x200</option>
<option value="600x300"{$sizecheck.600x300}>600x300</option>
<option value="800x400" style="border-bottom: 1px solid #000000;"{$sizecheck.800x400}>800x400</option>
<option value="240x240"{$sizecheck.240x240}>240x240</option>
<option value="400x400"{$sizecheck.400x400}>400x400</option>
<option value="600x600"{$sizecheck.600x600}>600x600</option>
<option value="800x800" style="border-bottom: 1px solid #000000;"{$sizecheck.800x800}>800x800</option>
<option value="120x240"{$sizecheck.120x240}>120x240</option>
<option value="200x400"{$sizecheck.200x400}>200x400</option>
<option value="300x600"{$sizecheck.300x600}>300x600</option>
<option value="400x800" style="border-bottom: 1px solid #000000;"{$sizecheck.400x800}>400x800</option>
<option value="240x320"{$sizecheck.240x320}>240x320</option>
<option value="480x640"{$sizecheck.480x640}>480x640</option>
<option value="600x800"{$sizecheck.600x800}>600x800</option>
<option value="768x1024"{$sizecheck.768x1024}>768x1024</option>
</select></td>
<td align="right" valign="middle">
<div><input type="submit" name="resize" value="&gt;&gt;" class="submit" id="100"></div>
</td></tr></table>
</td></tr></table>

<table border="0" cellpadding="2" cellspacing="1" width="100%" class="dashed">
<tr>
{if $smarty.session.admin}
<td valign="top" width="25%" align="center" class="tool{$focus.edit}">
<div><label for="edit"><img src="img/edit.png" width="20" height="20" hspace="0" vspace="0" border="0" alt="Edit" valign="top"></label><br />
<input type="radio" id="edit" name="action" value="edit"{if $focus.edit eq 'focus'} checked="checked"{/if} accesskey="r" /></div></td>
{/if}
<td valign="top" width="25%" align="center" class="tool{$focus.zoomout}">
<div><label for="zoomout"><img src="img/zoomout2.png" width="20" height="20" hspace="0" vspace="0" border="0" alt="Zoom Arrière" valign="top"></label><br />
<input type="radio" id="zoomout" name="action" value="zoomout"{if $focus.zoomout eq 'focus'} checked="checked"{/if} accesskey="a" /></div></td>
<td valign="top" width="25%" align="center" class="tool{$focus.travel}">
<div><label for="travel"><img src="img/travel.png" width="20" height="20" hspace="0" vspace="0" border="0" alt="Déplacement" valign="top"></label><br />
<input type="radio" id="travel" name="action" value="travel"{if $focus.travel eq 'focus'} checked="checked"{/if} accesskey="z" /></div></tD>
<td valign="top" width="25%" align="center" class="tool{$focus.zoomin}">
<div><label for="zoomin"><img src="img/zoomin2.png" width="20" height="20" hspace="0" vspace="0" border="0" alt="Zoom avant" valign="top"></lable><br />
<input type="radio" id="zoomin" name="action" value="zoomin"{if $focus.zoomin eq 'focus'} checked="checked"{/if}  accesskey="e" /></div></td>
</td></tr></table>

<table border="0" cellpadding="4" cellspacing="0" width="100%" class="dashed">
<tr><td valign="top">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
{$layermenu}</table>
<input type="submit" name="refresh" value="{tr}Rafraichir{/tr}" class="submit" id="106" />
</td></tr></table>

<div class="bar">Selection</div>
<select name="moyen">
<option value="">{tr}Moyen de locomotion{/tr}</option>
<option value="">{tr}... Indifférent{/tr}</option>
{section name=i loop=$moyens}
<option value="{$moyens[i]}">{$moyens[i]}</option>
{/section}
</select><br />

<select name="duree">
<option value="">{tr}Durée du parcours{/tr}</option>
<option value="">{tr}... Indifférent{/tr}</option>
{section name=i loop=$durees}
<option value="{$durees[i]}">{$durees[i]}</option>
{/section}
</select><br />

<select name="difficulte">
<option value="">{tr}Niveau de difficulté{/tr}</option>
<option value="">{tr}... Indifférent{/tr}</option>
{section name=i loop=$difficultes}
<option value="{$difficultes[i]}">{$difficultes[i]}</option>
{/section}
</select><br />

<input type="submit" name="action" value="{tr}Rechercher{/tr}" /><br />

{if $smarty.request.save eq 'all'}
<table>
<tr><td>Nom</td><td><input type="text" name="p_name" value="" /></td></tr>
<tr><td>Moyen de locomotion</td><td><select name="p_moyen">
{section name=i loop=$moyens}
<option value="{$moyens[i]}">{$moyens[i]}</option>
{/section}
</select></td></tr>
<tr><td>Duree</td><td>
<select name="p_duree">
{section name=i loop=$durees}
<option value="{$durees[i]}">{$durees[i]}</option>
{/section}
</select></td></tr>

<tr><td>Difficulté (1 facile, 5 tres dur)</td><td>
<select name="p_difficulte">
{section name=i loop=$difficultes}
<option value="{$difficultes[i]}">{$difficultes[i]}</option>
{/section}
</select></td></tr>
<tr><td></td><td><input type="submit" name="action" value="Enregistrer" /></td></tr>
</table>
{/if}
{if $smarty.session.admin}
click x : {$map_click.x}<br />
click y : {$map_click.y}<br />
extent : {$extent}<br />
<hr />
{foreach item=x from=$smarty.session.track}
<a href="{$url}?del={$x|escape:"url"}">[x]</a> <a href="">{$x}</a><br />
{/foreach}
<a href="{$url}?purge=all">purge</a>
<a href="{$url}?save=all">save</a>
<hr />
{/if}
</td></tr></table>
</form>
</div>

{include file="foot.tpl"}
