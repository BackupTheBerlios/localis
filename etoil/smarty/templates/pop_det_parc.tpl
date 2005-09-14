{include file="head_popup.tpl"}
<div style="margin: 20px">
<IMG src="etoil/logo.png" width="141" height="100" border="0" align="left">
<h3>{tr}Parcours{/tr} : {$parc_name}</h3>

<br/>{tr}Long_parcours{/tr} {$parc_length} m<br/><br/>
{if $deniv_ok}
{tr}Deniv_parcours{/tr} {$denivtot} m<br/><br/>
<img src="imgpostgraph.php" align="middle"><br/><br/>
{else}
{tr}No_deniv_infos{/tr}<br/><br/>
{/if}
<a href="#" class="button" onclick="window.close();">[&nbsp;{tr}fermer{/tr}&nbsp;]</a>
</div>
</body>