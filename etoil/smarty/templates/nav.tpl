<div class="nav">
<a href="index.php" class="noroll" {popup text="{tr}Accueil{/tr}"}><img src="etoil/logo.png" width="120" border="0" alt="{tr}Accueil{/tr}" /></a><br /><br />
<a href="map.php" class="navitem">{tr}Cartographie{/tr}</a>
<a href="help.php" class="navitem">{tr}Aide{/tr}</a>
<a href="questions.php" class="navitem" {popup text="{tr}FAQol{/tr}"}>{tr}FAQ{/tr}</a>
<a href="contact.php" class="navitem">{tr}Contact{/tr}</a>
<a href="apropos.php" class="navitem">{tr}A propos d'E-Toil{/tr}</a>
<br />
{if $smarty.session.me}
<a href="logout.php?from={$smarty.server.PHP_SELF|escape:'url'}" class="navitem">{tr}Quitter{/tr}</a>
{else}
<a href="login.php" class="navitem">{tr}Entrer{/tr}</a>
{/if}

<div class="cartouche">
<img src="etoil/logo_pract.png" border="0" /><br />
<img src="etoil/mentions_pract.png" border="0" /><br />
<img src="etoil/logo_instit.png" border="0" /><br /><br />
</div>
</div>
