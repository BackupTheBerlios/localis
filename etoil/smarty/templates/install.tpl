{include file="head.tpl"}

<div class="central admin">
{foreach item=i from=$mes}
{if $i[0] < 0}
<div class="negative">{$i[1]}</div>
{elseif $i[0] > 0}
<div class="positive">{$i[1]}</div>
{else}
<div class="neutral">{$i[1]}</div>
{/if}
{/foreach}
</div>

{include file="foot.tpl"}
