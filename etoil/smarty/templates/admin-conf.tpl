{include file="head.tpl"}

<div class="central admin">
<table>
<tr>
<td>
<form action="admin-conf.php" method="post">
{if $mod}
<input type="hidden" name="mod" value="{$focus.name}" />
<input type="hidden" name="save" value="1" />
{/if}
<table>
<tr><td>{tr}Name{/tr}</td><td><input type="text" name="f[name]" value="{$focus.name}" size="12" /></td></tr>
<tr><td>{tr}Value{/tr}</td><td><textarea name="f[value]" cols="34" rows="4">{$focus.value}</textarea></td></tr>
<tr><td>&nbsp;</td><td><input type="submit" name="act" value="{tr}Enregistrer{/tr}" /></td></tr>
</table>
</form>
</td>
<td>
<form action="admin-conf.php" method="post">
Pour ajouter plusieurs variables de configuration, indiquez sur chaque ligne<br /> <b><tt>Variable, Valeur</tt></b><br />
<textarea cols="62" rows="4" name="newconflines"></textarea><br />
<input type="submit" name="act" value="{tr}Ajouter{/tr}" />
</form>
</td>
</tr></table>

<hr />

<table cellpadding="0" cellspacing="0" class="table">
<tr>
<th>&nbsp;</th>
<th>{tr}Variable{/tr}</th>
<th>{tr}Valeur{/tr}</th>
<th>&nbsp;</th>
</tr>
{foreach item=u from=$confs}
<tr>
<td><a href="admin-conf.php?del={$u.name|escape:'url'}">DEL</a></td>
<td><b>{$u.name|default:"&nbsp;"}</b></td>
<td><pre>{$u.value|default:"&nbsp;"}</pre></td>
<td><a href="admin-conf.php?mod={$u.name|escape:'url'}">MOD</a></td>
{/foreach}
</table>
</div>

{include file="foot.tpl"}
