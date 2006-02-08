{include file="head.tpl"}

<div class="central">
<div style="text-align:center;">
<img src="etoil/feuille_limousin.png" border="0" width="60" height="90" alt="Limousin" /><br />
<h2>E-TOIL</h2>
<div class="base"><b>e</b>-<b>T</b>echnologie d'<b>O</b>rientation  <b>I</b>nteractive en <b>L</b>imousin</div>
</div>
<br /><br />
{if $avertTEST_SRV}
<script language="javascript">
alert('Attention: ce site est dï¿½ormais exclusivement un site de test et ne contient plus de donï¿½s ï¿½jour; merci d`aller sur www.e-toil.com');
</script>
{/if}

{if true}

<div>Vous &#234;tes : randonneur &#224; pied ou randonneur &#224; cheval ou randonneur &#224; VTT ou randonneur en canoe-kayak, et vous souhaitez d&#233;couvrir ou red&#233;couvrir le
Limousin.<br>
 Vous trouverez ici un outil de consultation en temps r&#233;el de chemins de randonn&#233;s quel que soit la discipline que vous pratiquez.</div>
<br /><br />
Apr&#232;s deux ann&#233;es de gestation, e-toil est mis en ligne et ouvert au public.<br>
A l'heure actuelle, les offres de circuits sont limit&#233;es, mais ce site est appell&#233; a se d&#233;velopper et proposer un r&#233;seau de chemins de plus en plus &#233;toff&#233;..<br><br>
	<div align="center"><a href="map.php"><i>Finissez d'entrer</i> et d&#233;couvrez votre randonn&#233;e...</a></div>
{ else}
<div align="center">
<br><B>Nous travaillons en ce moment &#224;  l'ouverture de ce site qui sera ouvert dans la matin&#233;e...<br><br>
Merci de votre patience et de votre compr&#233;hension.
</B>
<br><br>
Sur ce site de test, il est necessaire de s'<a href="login.php">identifier</a> pour pouvoir consulter la cartographie...
</div>
{ /if}
</div>

{include file="foot.tpl"}
