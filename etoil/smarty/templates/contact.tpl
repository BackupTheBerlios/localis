{include file="head.tpl"}

<div class="central">
<form action="contact.php" method="post">
{if $me}
{tr}Votre login{/tr} <b>{$me}</b><br />
{else}
{tr}Votre email{/tr}<br />
<input type="text" name="from" value="{$sub_form}" />
{/if}
<div>{tr}formulaire de contact.{/tr}</div>
<textarea cols="60" rows="10" name="meat">{$sub_meat}</textarea><br />
<input type="submit" name="act" value="{tr}Envoyer{/tr}" />
</form>
</div>

{include file="foot.tpl"}
