<form action="{$url}" method="post">
Etes-vous sur de vouloir effacer<br />
<div class="box">{$item} <b>{$params.del}</b></div>
{foreach key=k item=i from=$params}
<input type="hidden" name="{$k}" value="{$i}" />
{/foreach}
<input type="submit" name"act" value="{tr}Confirmer{/tr}" />
</form>
