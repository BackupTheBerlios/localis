{include file="head.tpl"}

<div class="central admin">
<table>
<tr>
<td>
<form action="admin-users.php" method="post">
{if $mod}
<input type="hidden" name="f[credential]" value="{$focus.credential}" />
<input type="hidden" name="mod" value="{$focus.login}" />
<input type="hidden" name="save" value="1" />
{/if}
<table>
<tr><td>{tr}Login{/tr}</td><td><input type="text" name="f[login]" value="{$focus.login}" size="12" /></td></tr>
<tr><td>{tr}Mot de passe{/tr}</td><td><input type="text" name="f[pass]" value="" size="12" /></td></tr>
<tr><td>{tr}Email{/tr}</td><td><input type="text" name="f[email]" value="{$focus.email}" size="22" /></td></tr>
<tr><td>{tr}Biography{/tr}</td><td><input type="text" name="f[bio]" value="{$focus.bio}" size="32" /></td></tr>
<tr><td>&nbsp;</td><td><input type="submit" name="act" value="{tr}Enregistrer{/tr}" /></td></tr>
</table>
</form>
</td>
<td>
<form action="admin-users.php" method="post">
Pour ajouter des utilisateurs, indiquez sur chaque ligne<br /> <b><tt>login, pass, email, biographie</tt></b><br />
<textarea cols="62" rows="4" name="newusers"></textarea><br />
<input type="submit" name="act" value="{tr}Ajouter{/tr}" />
</form>
</td>
</tr></table>

<hr />

<table cellpadding="0" cellspacing="0" class="table">
<tr>
<th>&nbsp;</th>
<th>{tr}login{/tr}</th>
<th>{tr}email{/tr}</th>
<th>{tr}bio{/tr}</th>
<th>{tr}admin{/tr}</th>
<th>&nbsp;</th>
</tr>
{foreach item=u from=$users}
<tr>
<td><a href="admin-users.php?del={$u.login|escape:'url'}">DEL</a></td>
<td><b>{$u.login|default:"&nbsp;"}</b></td>
<td>{$u.email|default:"&nbsp;"}</td>
<td>{$u.bio|default:"&nbsp;"}</td>
<td>{if $u.credential gt 0}
<a href="admin-users.php?dem={$u.login|escape:'url'}" title="{tr}Enlever le privilege d'admin{/tr}">admin</a>
{else}
<a href="admin-users.php?adm={$u.login|escape:'url'}" title="{tr}Attribuer le privilège d'admin{/tr}">--</a>
{/if}</td>
<td><a href="admin-users.php?mod={$u.login|escape:'url'}">MOD</a></td>
{/foreach}
</table>
</div>

{include file="foot.tpl"}
