<html>
<head>
<title>{tr}E-Toil{/tr}</title>
<meta http-equiv="Content-Language" content="{$language}">
<link rel="StyleSheet" type="text/css" href="etoil.css" />
<script>
function toggletool(id) {literal}{{/literal}
{if $smarty.session.admin}
	document.getElementById('tool_edit').style.border='0';
	document.getElementById('tool_edit').style.backgroundColor='#fff';
{/if}
	document.getElementById('tool_zoomin').style.border='0';
	document.getElementById('tool_travel').style.border='0';
	document.getElementById('tool_zoomout').style.border='0';
	document.getElementById('tool_zoomin').style.backgroundColor='#fff';
	document.getElementById('tool_travel').style.backgroundColor='#fff';
	document.getElementById('tool_zoomout').style.backgroundColor='#fff';
	document.getElementById(id).style.border='1px solid #000';
	document.getElementById(id).style.backgroundColor='#ddd';
{literal}}{/literal}
</script>
</head>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr><td width="145">
{include file="nav.tpl"}
</td>
<td colspan="2">
<div class="headbar">
{if $smarty.session.admin}
<a href="admin-users.php" class="adminlink">Users</a>
<a href="admin-conf.php" class="adminlink">Conf</a>
<a href="admin-purge.php?from={$smarty.server.PHP_SELF}" class="adminlink">Purge</a>
<a href="techdata.php" class="adminlink">Tech Data</a>
{else}
&nbsp;
{/if}
</div>

<div class="title">{if $langs}
<span style="float:right;padding-top:2px;font-size:7pt;">
{foreach item=l from=$langs}{if $language eq $l}
<a href="{$phpself}?lang={$l}"><img src="img/{$l}.png" width="18" height="12" vspace="0" hspace="0" alt="{$l}" border="3" /></a>
{else}
<a href="{$phpself}?lang={$l}"><img src="img/{$l}.png" width="18" height="12" vspace="2" hspace="2" alt="{$l}" border="1" /></a>
{/if}
{/foreach}
</span>
{/if}
{if $title}
<a href="{$url}">{tr}{$title}{/tr}</a>
{/if}</div>


<table width="100%" border="0" cellpadding="0" cellspacing="0" style="clear:both;">
<tr><td>

{if count($feedback)}{include file="inc.feedback.tpl"}{/if}


