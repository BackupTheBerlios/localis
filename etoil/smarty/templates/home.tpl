{include file="head.tpl"}

<div class="central">
<div style="text-align:center;">
<img src="etoil/feuille_limousin.png" border="0" width="60" height="90" alt="Limousin" /><br />
<h2>E-TOIL</h2>
<div class="base"><b>e</b>-<b>T</b>echnologie d'<b>O</b>rientation  <b>I</b>nteractive en <b>L</b>imousin</div>
</div>
<br /><br />

<div>Vous �tes randonneur � pied, � cheval, en v�lo, � VTT ou en cano� kayak, et vous souhaitez d�couvrir ou red�couvrir le Limousin. <br/><br/>
E-toil va vous permettre de s�lectionner la randonn�e de votre choix, et vous donner toutes les informations connexes..</div>
<br /><br />

{if $bool_map_disp}

<div align="center"><a href="map.php">Entrez et d�couvrez votre randonn�e...</a></div>
{ else}
<div align="center">Sur ce site de test, il est n�c�ssaire de s'<a href="login.php">identifier</a> pour pouvoir consulter la cartographie...</div>
{ /if}
</div>

{include file="foot.tpl"}
