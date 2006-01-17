{include file="head.tpl"}
{popup_init src="js/overlib.js"}

{* le code d'init de l'arbre DL3Tree, $DL3TJSVarsInit et $DL3TJSVarsFunctions est appel? dans head.tpl*}

{literal}
<!-- avant on appelait cet arbre 
<script language="Javascript" type="text/javascript" src="js/tree.js"></script>
-->

<script language="JavaScript">
// cette fonction est appelée quand on vuet télécharger (uploader) un fichier
// en effet, les upload ne marchent correctement qu'en méthode POST
//alert ('IE est une grosse merde');
function ChgMeth() {
document.f.method="POST";
}
</script>
{/literal}

<div class="central">
{if $bool_map_disp}
<form name="f" enctype="multipart/form-data">
<input type="hidden" name="extent" value="{$extent}" />
<table border="0" cellpadding="0" cellspacing="0"> { * table principale à 2 colonnes*}

{if $smarty.session.pid}
<tr><td colspan="2" class="feedback">
<div class="positive"><img src="img/ico/notice.png" width="14" height="14" alt="notice" border="0" hspace="2" vspace="0" align="baseline" />Vous affichez actuellement les détails du parcours <u>{$parc_name}</u></div>
</div></td></tr>
<tr><td colspan="2"><img src="img/dot0.png" height="{$blockspc}"></td></tr>
{/if}

<tr><td width="{math equation="(x * 2) + y + 2" x=$mapmargin y=$sizex}" valign="top">
{* carte principale *}
<map name="localisation" id="localisation">
{if count($tracks)}
{*definit des area cliquables sur les pictos des parcours*}
{section name=i loop=$tracks}
<area href="{$url}?pid={$tracks[i].parcours_id}" name="{$tracks[i].parcours_id}" id="{$tracks[i].parcours_id}" shape="rect" coords="{$tracks[i].rect}" {popup text=$tracks[i].parcours_name|default:" "} />
{/section}
{/if}
{*definit des area cliquables sur les pictos des points LEI*}
{if count($ppmplei)}
{section name=i loop=$ppmplei}
{if $bool_lei_stat eq "true"}
<area href="fiche lei" onclick="return(popup('{$url_lei_stat}'));" name="{$ppmplei[i].lei_f_libelle}" id="{$ppmplei[i].lei_f_id}" shape="rect" coords="{$ppmplei[i].rect}" {popup text=$ppmplei[i].lei_f_libelle|default:" "} />
{else}
<area href="fiche lei" onclick="return(popup('{$lei_f_url}{$ppmplei[i].lei_f_id}'));" name="{$ppmplei[i].lei_f_libelle}" id="{$ppmplei[i].lei_f_id}" shape="rect" coords="{$ppmplei[i].rect}" {popup text=$ppmplei[i].lei_f_libelle|default:" "} />
{/if}
{/section}
{/if}

</map>
<!--<input type="image" src="img/dot1.png" width="10" height="10" border="3" name="dir" value="cc" />-->
<table cellspacing="0" cellpadding="0" border="0"><tr>
<td width="{$mapmargin}"><input {popup text="{tr}Vers le Nord-Ouest{/tr}"} type="image" src="img/flecheHG.gif" width="{$mapmargin}" height="{$mapmargin}" border="0" name="dir_lt" value="lt" /></td>
<td width="{$sizex+2}" align="center" class="navmap" onclick="document.getElementById('ct').click();" {popup text="{tr}Vers le Nord{/tr}"} 
><input id="ct" type="image" src="img/flecheH.gif" border="0" name="dir_ct" value="ct" /></td>
<td width="{$mapmargin}"><input {popup text="{tr}Vers le Nord-Est{/tr}"} type="image" src="img/flecheHD.gif" border="0" name="dir_rt" value="rt" /></td>
</tr><tr>
<td class="navmap" onclick="document.getElementById('lc').click();" {popup text="{tr}Vers l'Ouest{/tr}"}
><input id="lc" type="image" src="img/flecheG.gif" border="0" name="dir_lc" value="lc" /></td>
<td><input type="image" src="{$mapimage}" width="{$sizex}" height="{$sizey}" alt="" border="1" hspace="0" vspace="0" class="map" valign="top">
<!--<input type="image" src="{$mapimage}" width="{$sizex}" height="{$sizey}" alt="" border="1" hspace="0" vspace="0" class="map" usemap="#localisation" valign="top">-->
</td>
<td class="navmap" onclick="document.getElementById('rc').click();" {popup text="{tr}Vers l'Est{/tr}"} 
><input id="rc" type="image" src="img/flecheD.gif" border="0" name="dir_rc" value="rc" /></td>
</tr><tr>
<td><input {popup text="{tr}Vers le Sud-Ouest{/tr}"} type="image" src="img/flecheBG.gif" border="0" name="dir_lb" value="lb" /></td>
<td class="navmap" align="center" onclick="document.getElementById('cb').click();" {popup text="{tr}Vers le Sud{/tr}"} 
><input id="cb" type="image" src="img/flecheB.gif" border="0" name="dir_cb" value="cb" /></td>
<td><input {popup text="{tr}Vers le Sud-Est{/tr}"} type="image" src="img/flecheBD.gif" border="0" name="dir_rb" value="rb" /></td>
</tr><tr>
<td colspan="3"><img src="img/dot0.png" height="{$blockspc}"></td>
</tr>
</table>

{* legende sous la carte avec les icônes de disciplines*}
<table cellpadding="0" cellspacing="0" border="0"><tr>
{foreach name=leg key=k item=i from=$legends}
{if $filtre.discp eq $smarty.foreach.leg.iteration}
<td class="bar2" width="20" style="width:20px;"><img src="{$i}" width="20" height="18" hspace="0" vspace="0" border="0" alt="" /></td>
<td class="bar2"><b style="margin: 0 15px 0 3px;font-size:12px;">{$k}</b></td><td>&nbsp;</td>
{else}
<td width="20" style="width:20px;"><img src="{$i}" width="20" height="18" hspace="0" vspace="0" border="0" alt="" /></td>
<td><a href="#" onclick="document.getElementById('ftype').value='{$smarty.foreach.leg.iteration}'; document.f.search.click();" class="leg">{$k}</a></td><td>&nbsp;</td>
{/if}
{/foreach}
</tr></table>
{* aff. echelle *}
<div class="foot" style="margin-left:10px;" id="light">{tr}Scale{/tr}: 1 / {$scale} 
{if $booldisplegscan100}
&nbsp;&nbsp;&nbsp;<a href="#legend">->{tr}LLegenscan100{/tr}</a>
{/if}

{if $smarty.session.admin and $map_click}[x {$map_click.x} - y {$map_click.y} ]{/if}
</div>
<div class="foot" style="margin-top:10px;margin-bottom:2px;margin-left:10px;"><a href="{$mapimage}" target="_new" class="submit" {popup text="{tr}TelechImgCol{/tr}"}>{tr}TelechImgC{/tr}</a></div>
</td>


{* colonne de droite tableau principal*}

<td style="padding-left : 10px;">

<div class="bar">{tr}Affichage{/tr}</div>

<table border="0" cellpadding="1" cellspacing="0" id="map">
<tr><td valign="middle">
{* zooms et déplacement *}
<table border="0" cellpadding="2" cellspacing="1" class="navbar">
<td valign="middle" align="center" class="tool{$focus.zoomout}" id='tool_zoomout'>
<div {popup text="{tr}Eloigner{/tr} [ Alt-e ]"}><label for="zoomout" accesskey="e"><img src="img/zoomout2.png" width="20" height="20" hspace="0" vspace="0" border="0" alt="Zoom Arrière" valign="top"></label>
<input type="radio" id="zoomout" name="action" value="zoomout"{if $focus.zoomout eq 'focus'} checked="checked" {/if} onchange="toggletool('tool_zoomout'); if (this.checked) document.f.submit();"/></div></td></tr><tr>
<td valign="middle" width="25%"  align="center" class="tool{$focus.travel}" id='tool_travel'>
<div {popup text="{tr}Déplacer{/tr} [ Alt-d ]"}><label for="travel" accesskey="d"><img src="img/travel.png" width="20" height="20" hspace="0" vspace="0" border="0" alt="Déplacement" valign="top"></label>
<input type="radio" id="travel" name="action" value="travel"{if $focus.travel eq 'focus'} checked="checked" {/if} onchange="toggletool('tool_travel')" /></div></td><tr></tr>
<td valign="middle" align="center" class="tool{$focus.zoomin}" id='tool_zoomin'>
<div {popup text="{tr}Rapprocher{/tr} [ Alt-r ]"}><label for="zoomin" accesskey="r"><img src="img/zoomin2.png" width="20" height="20" hspace="0" vspace="0" border="0" alt="Zoom avant" valign="top"></label>
<input type="radio" id="zoomin" name="action" value="zoomin"{if $focus.zoomin eq 'focus'} checked="checked" {/if} onchange="toggletool('tool_zoomin')" /></div></td>
</td></tr></table></td>

{* carte de localisation *}
<td valign="top" align="left">
<input type="image" src="{$refsrc}" width="{$refwidth}" height="{$refheight}" name="ref" alt="{$name}" hspace="0" vspace="0" border="0"><img src="img/francepti.jpg" width="100" height="100" border="0" />
{* choix de la taille*}
<br/>
<select name="size" class="submit" id="100" onchange="document.f.resize.value='y' ; document.f.submit();" {popup text="{tr}ImgSize{/tr}"}>
<option value="240x240"{$sizecheck.240x240}>240x240</option>
<option value="400x400"{$sizecheck.400x400}>400x400</option>
<option value="500x500"{$sizecheck.500x500}>500x500</option>
<option value="600x600"{$sizecheck.600x600}>600x600</option>
<option value="800x800"{$sizecheck.800x800}>800x800</option>
</select>
&nbsp;&nbsp;&nbsp;
<input type="image" src="img/expand.png" width="16" height="11" name="fit" value="{tr}Recadrer{/tr}" class="submit" onclick="document.f.extent.value=''; document.f.submit();"
{popup text="{tr}Recadrer{/tr} [ Alt-c ]"} accesskey="c" /></td>
</tr>
</table>

<input type="hidden" name="resize" value="n" />

{* recherche par commune *}
<div class="smbar">{tr}Localiser une commune{/tr}</div>
<input type="text" name="ville" value="" style="width:80%;" /><br />
{if $cities}
<div class="found">
{section name=o loop=$cities}
{$cities[o].code_postal}
<a href="{$url}?idfocusville={$cities[o].id}&focusville={$cities[o].nom|escape:"url"}">{$cities[o].nom}</a><br />
{/section}
</div>
{elseif $city_info}
<div class="found">
{$city_info[0].code_postal}
{$city_info[0].nom}
</div>
{/if}
{if $pid ne "" }
 <input type="submit" class="button" name="search" value="{tr}Rechercher{/tr}" />{/if}
 

{if $pid eq "" }
	{* bloc d'outils d'edition, import de tracés(conditionnel, si user non blaireau) *}
	{if $smarty.session.admin} 
	<img src="img/dot0.png" height="{$blockspc}">
	<div class="bar">{tr}Edition import de tracé{/tr}</div>
	<table border="0" cellpadding="2" cellspacing="1" width="100%" class="navbar">
	<tr>
	<td valign="top" width="30%" align="center" class="tool{$focus.edit}" id='tool_edit'>
	<div {popup text="{tr}Ajouter{/tr} [ Alt-a ]"}><label for="edit" accesskey="a"><img src="img/edit.png" width="20" height="20" hspace="0" vspace="0" border="0" alt="Edit" valign="top"></label>
	<input type="radio" id="edit" name="action" value="edit"{if $focus.edit eq 'focus'} checked="checked"{/if} onchange="toggletool('tool_edit');"/></div></td>
	<td colspan="2" width="70%"><input {popup text="{tr}Importer{/tr}"} type="file" size="10" name="trackfileimp" Onchange="ChgMeth()"/>
	<br>Code user a affecter : <input type="text" name="usertrck">
	<br>Code marqimp a affecter : <input type="text" name="marqimp" value="toto">
	</td>
	</tr>
	<tr><TD>&nbsp;</TD><TD colspan="2"><input {popup text="{tr}pas de visu préalable ni de choix de nom{/tr}"} type="checkbox" name="tf_dir_import" value="yes">{tr}Import direct{/tr}</TD></tr>
	</table>
	Facteur de zoom :<input type="text" name="zoomc" value="" /><br />
	
	{* bloc d'enregistrement/modification de tracé (conditionnel, si user non blaireau) *}
	<img src="img/dot0.png" height="{$blockspc}">
	{if $smarty.request.do eq "{tr}Enregistrer{/tr}"}
	<div class="bar">{tr}Edition/ajout de tracé{/tr}</div>
	<table class="inputable">
	<tr><td>Nom</td><td><input type="text" name="p_name" value="" /></td></tr>
	<tr><td>{tr}Discipline{/tr}</td><td>
	<select name="p_discp">
	{foreach key=k item=i from=$discps}
	<option value="{$k}"{if $filtre.discp eq $k} selected="selected"{/if}>{$i}</option>
	{/foreach}
	</select></td></tr>
	
	<tr><td>{tr}Durée{/tr}</td><td>
	<select name="p_time">
	{foreach key=k item=i from=$times}
	<option value="{$k}"{if $filtre.time eq $k} selected="selected"{/if}>{$i}</option>
	{/foreach}
	</select></td></tr>
	
	<tr><td>{tr}Difficulté{/tr} (1 facile, 5 tres dur)</td><td>
	<select name="p_level">
	{foreach key=k item=i from=$levels}
	<option value="{$k}"{if $filtre.level eq $k} selected="selected"{/if}>{$i}</option>
	{/foreach}
	</select></td></tr>
	
	<tr><td><input type="submit" class="button" name="do" value="{tr}Effacer{/tr}" /></td><td><input type="submit" class="button" name="action" value="{tr}Enregistrer{/tr}" /></td></tr>
	</table>
	{/if}
	{if count($smarty.session.track)}
	<div class="bar">{tr}Coordonnées du tracé{/tr}</div>
	{if $smarty.request.do ne "{tr}Enregistrer{/tr}"}
	<input type="submit" class="button" name="do" value="{tr}Effacer{/tr}" />
	<input type="submit" class="button" name="do" value="{tr}Undo{/tr}" />
	<input type="submit" class="button" name="do" value="{tr}Enregistrer{/tr}" /><br />
	{/if}<small>
	{foreach item=x from=$smarty.session.track}
	<a href="#"><img src="img/small_edit.gif" border="0"></a> <a href="#"><img src="img/small_garbage.gif" border="0"></a> <a href="#"><img src="img/small_info.gif" border="0"></a> {$x}<br />
	{/foreach}
	</small>
	<hr />
	{/if}
	{/if}
	{* FIN bloc d'enregistrement/modification de tracé *}
	
	{* bloc de sélection critères tracés *}
	<img src="img/dot0.png" height="{$blockspc}">
	<div class="bar">Selection des parcours</div>
	<table border="0" cellpadding="0" cellspacing="0" width="100%">
	<tr><td>{tr}Discipline{/tr}&nbsp;</td><td>
	<select class="selection" name="filtre[discp]" id="ftype">
	<option value="none">{tr}Aucune{/tr}</option>
	{foreach key=k item=i from=$discps}
	<option style="color:#{$discpcolor.$k}" value="{$k}"{if $filtre.discp eq $k} selected="selected"{/if}>{$i}</option>
	{/foreach}
	</select></td></tr>
	
	
	<tr><td>{tr}Nom{/tr}</td><td>
	<input type="text" name="filtre[name]" value="{$filtre.name}">
	</td></tr>
	
	{if $smarty.session.admin}
	<tr><td>{tr}Id{/tr}</td><td>
	<input type="text" name="filtre[id]" value="{$filtre.id}">
	</td></tr>
	{/if}
	
	<tr><td>{tr}Durée{/tr}&nbsp;</td><td>
	<select  class="selection" name="filtre[time]">
	<option value="">{tr}... Indifférent{/tr}</option>
	{foreach key=k item=i from=$times}
	<option value="{$k}"{if $filtre.time eq $k} selected="selected"{/if}>{$i}</option>
	{/foreach}
	</select></td></tr>
	
	<tr><td>{tr}Difficulté{/tr}&nbsp;</td><td>
	<select  class="selection" name="filtre[level]">
	<option value="">{tr}... Indifférent{/tr}</option>
	{foreach key=k item=i from=$levels}
	<option value="{$k}"{if $filtre.level eq $k} selected="selected"{/if}>{$i}</option>
	{/foreach}
	</select></td></tr>
	<tr><td>&nbsp;</td><td>
	<input type="submit" class="button" name="search" value="{tr}Rechercher{/tr}" />
	</td></tr></table>
	
	{* liste des parcours correspondant à la sélection *}
	{if $tracks}
	<img src="img/dot0.png" height="{$blockspc}">
	<div class="smbar">Parcours correspondant aux critères</div>
	{if count($tracks) < $maxdisptracks}
	<ul style="font-size:9pt;">
	{section name=t loop=$tracks}
	{assign var=v value=$tracks[t].parcours_discp}
	<li style="color:#{$discpcolor.$v}"><a style="color:#{$discpcolor.$v}" href="{$url}?pid={$tracks[t].parcours_id}" {popup text="{tr}ParcZoom{/tr}"}>#{$tracks[t].parcours_id}: {$tracks[t].parcours_name}</a> <a href="file_export.php?parcours_id={$tracks[t].parcours_id}"  {popup text="{tr}CE3Down{/tr}"}>[->CE3]</a> <a href="file_export.php?parcours_id={$tracks[t].parcours_id}&fexpf=shp" {popup text="{tr}SHPDown{/tr}"}>[->SHP]</a></li>
	{/section}
	</ul>
	{else}
	{tr}TomuchLparc{/tr}
	{/if}
	{else}
	{if $filtre}<div class="negative">{tr}0Lparc{/tr}</div>{/if}
	{/if}
	
	
{else} {* mode tracé unique *}
	<div class="bar">{tr}Det_parcours{/tr}<br/>
	<em>{$parc_name}</em></div>
	<ul>
	<li>{tr}Long_parcours{/tr} {$parc_length} m</li>
	<li>{tr}ptime{/tr} {$parc_time} h</li>
	
	<li>
	{if $denivtot>0}
	{tr}Deniv_parcours{/tr} {$denivtot} m</li>
	{else}
	{tr}No_deniv_infos{/tr}<br/>
	{/if}
	
	<LI>{tr}CE3Down{/tr}:<a href="file_export.php?parcours_id={$pid}" {popup text="{tr}CE3Down2{/tr}"}><img src="img/ce3_ico.jpg" border="0"></a></LI>
	<LI>{tr}SHPDown{/tr}:<a href="file_export.php?parcours_id={$pid}&fexpf=shp" {popup text="{tr}SHPDown2{/tr}"}>[->SHP]</a></LI>
	<li><a href="#mdet" {popup text="{tr}MoreDet2{/tr}"}>{tr}MoreDet{/tr}</a></li>
	</ul>
	<!-- <img src="imgpostgraph.php" align="middle"><br/>-->
	<input id="hnu" type="hidden" name="notunique" value="false">
	<input type="submit" onclick="document.getElementById('hnu').value=true; document.f.submit()" class="button" name="toto" value="{tr}FermePU{/tr}" {popup text="{tr}FermePUDesc{/tr}"}/>
	<br/>
{/if}
	
{* bloc de sélection points du LEI *}
<img src="img/dot0.png" height="{$blockspc}">
<div class="smbar"  {popup text="{tr}LEIPointsInfo{/tr}"}>{tr}LEIPointsSel{/tr}</div>
{if !$avertMSIE}
{$DL3TJStbChilds}
<div class="leitree" id="tree">{$tree_lei}</div>
 
<br/><input type="submit" class="button" name="search" value="{tr}Rechercher{/tr}"/>
{else}
<div class="negative">
Vous utilisez le navigateur Micro$oft Internet Explorer, qui n'est pas conforme aux spécifications du W3C.<br/>
<b>Nous ne sommes de ce fait pas en mesure d'afficher les fiches "<em>{tr}LEIPointsSel{/tr}</em>" avec ce navigateur</b><br>
Nous vous recommandons d'utiliser <a href="http://www.mozilla-europe.org/fr/products/firefox/">Mozilla Firefox</a> (gratuit et librement téléchargeable).
</div>
{/if}

</td></tr></table> {* fin du grand tableau général de colonnes *}
{if $pid ne "" }
<a name="mdet" />
<div class="bar">{tr}Det_parcours{/tr} <em>{$parc_name}</em></div>

{$tb_infparc}
<br/><p align="center"><input type="submit" onclick="document.getElementById('hnu').value=true; document.f.submit()" class="button" name="toto" value="{tr}FermePU{/tr}" {popup text="{tr}FermePUDesc{/tr}"}/></p>
{/if}

</form>
{ else } 
Sur ce site prototype de test, il est nécessaire de s'identifier et d'être habilité pour pouvoir consulter les cartes.<br/>
<br/>
Veuillez contacter {mailto address="artec.vm@nerim.net" encode="javascript" subject="Activer un compte sur e-toil.net"} pour créer ou activer un compte.
Merci.
{/if}
{if $booldisplegscan100}
<a name="legend" />
<div class="bar">{tr}Legenscan100{/tr}</div>
<IMG src="../img/legend1_scan100.jpg" alt="Legende 1" border="0">
<br/>
<IMG src="../img/legend2_scan100.jpg" alt="Legende 1" border="0">
{/if}
</div>
{include file="foot.tpl"}
