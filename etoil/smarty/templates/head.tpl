<html>
<head>
<title>{tr}E-Toil{/tr}</title>
<meta http-equiv="Content-Language" content="{$language}">
<link rel="StyleSheet" type="text/css" href="etoil.css" />
</head>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr><td width="145">
{include file="nav.tpl"}
</td>
<td colspan="2">
<div class="headbar">
{if $smarty.session.admin}
<a href="admin-users.php" class="adminlink">Admin Users</a>
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


