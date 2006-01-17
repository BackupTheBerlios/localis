<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<title>{tr}E-Toil{/tr}</title>
<meta http-equiv="Content-Language" content="{$language}">
<!--<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">-->
<link rel="StyleSheet" type="text/css" href="etoil.css" />
<script>
function toggletool(id) {literal}{{/literal}
{if $smarty.session.admin && !($smarty.session.pid)}
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
	document.getElementById(id).style.backgroundColor='#dff1d3';
{literal}}{/literal}
{literal}
var oPopupWin; // stockage du handle de la popup
function popup(page, width, height) {
    NavVer=navigator.appVersion;
    var defwidth='400';
    var defheight='500';
    if (NavVer.indexOf("MSIE 5.5",0) == -1 && NavVer.indexOf("MSIE 6.",0) == -1) {
        var undefined;
        undefined='';
        }

    var tmp;
    if (oPopupWin) {
        // Make sure oPopupWin is empty before
        // calling .close() or we could throw an
        // exception and never set it to null.
        tmp = oPopupWin;
        oPopupWin = null;
        // Only works in IE...  Netscape crashes
        // if you have previously closed it by hand
        if (navigator.appName != "Netscape") tmp.close();
      }
  if (width==undefined)
  width=defwidth;
  if (height==undefined)
  height=defheight;
    oPopupWin = window.open(page, "IntlPopup", "alwaysRaised=1,dependent=1,height=" + height + ",location=0,menubar=0,personalbar=0,scrollbars=1,status=0,toolbar=0,width=" + width + ",resizable=1");
	oPopupWin.focus();
	// valeur de retour différente suivant navigateur (merdique a souhait) !!!
	var bAgent = window.navigator.userAgent;
	var bAppName = window.navigator.appName;
	if ((bAppName.indexOf("Explorer") >= 0) && (bAgent.indexOf("Mozilla/3") >= 0) && (bAgent.indexOf("Mac") >= 0))
		return true; // dont follow link
	else return false; // dont follow link
	//return !oPopupWin;

}

{/literal}

</script>
{if !$avertMSIE}
	
	{ * appel du code pour l'arbre dans le map*}
	{ $DL3TJSVarsInit }
	{ $DL3TJSFunctions }
	{ $DL3TStyles }

{/if}

</head>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%">
<tr><td width="120">
{include file="nav.tpl"}
</td>
<td>
<div class="headbar{if $title==Cartographie}WI{/if}">
{* les images de fond sont dans la classe, et il n'y a en pas pour la carto (WI=without images) *}
</div>
{if $avertMSIE && $title!=Cartographie}
<div class="negative">
Vous utilisez le navigateur Micro$oft Internet Explorer, qui n'est pas conforme aux spécifications du W3C. Certaines parties de ce site pourront donc ne pas fonctionner correctement. Nous vous recommandons d'utiliser <a href="http://www.mozilla-europe.org/fr/products/firefox/">Mozilla Firefox</a> (gratuit et librement téléchargeable), ou encore <a href="http://www.opera.com">Opera</a>, navigateurs qui en plus d'être conformes, possèdent bien d'autres avantages : immunité aux chevaux de troie et autres hoax, blocage des popups non sollicitées, multi-fenêtres.
</div>
{/if}
<div class="title">
<span style="float:right;padding-top:2px;font-size:7pt;">
{if $smarty.session.me}
<small>{tr}IdConn{/tr}: <b>{$smarty.session.me}</b></small>&nbsp;&nbsp;&nbsp;
{/if}
{if $langs}
	{foreach item=l from=$langs}
		{if $language eq $l}
			<a href="{$phpself}?lang={$l}"><img src="img/{$l}.png" width="18" height="12" vspace="0" hspace="0" alt="{$l}" border="3" /></a>
		{else}
			<a href="{$phpself}?lang={$l}"><img src="img/{$l}.png" width="18" height="12" vspace="2" hspace="2" alt="{$l}" border="1" /></a>
		{/if}
	{/foreach}
{/if}
</span>
{if $title}
{tr}{$title}{/tr}
{/if}

</div>


{if count($feedback)}{include file="inc.feedback.tpl"}{/if}


