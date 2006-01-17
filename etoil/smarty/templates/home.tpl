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
alert('Attention: ce site est désormais exclusivement un site de test et ne contient plus de données à jour; merci d`aller sur www.e-toil.com');
</script>
{/if}
<div>Vous êtes : randonneur à pied ou randonneur à cheval ou randonneur à VTT ou randonneur en canoë kayak, et vous souhaitez découvrir ou redécouvrir le
Limousin. Vous trouverez un outil de création en temps réel de chemins de randonnées quel que soit votre mode de locomotion.</div>
<br /><br />

{if $bool_map_disp}

<div align="center"><a href="map.php">Entrez et découvrez votre randonnée...</a></div>
{ else}
<div align="center">Sur ce site de test, il est nécéssaire de s'<a href="login.php">identifier</a> pour pouvoir consulter la cartographie...</div>
{ /if}
</div>

{include file="foot.tpl"}
