<div class="feedback">
{section name=a loop=$feedback}
{if !$feedback[a].num or $feedback[a].num eq 0}
<div class="neutral">{icon type=info}{$feedback[a].msg}</div>
{elseif $feedback[a].num gt 0}
<div class="positive">{icon type=notice}{$feedback[a].msg}</div>
{else}
<div class="negative">{icon type=error}{$feedback[a].msg}</div>
{/if}
{/section}
</div>

