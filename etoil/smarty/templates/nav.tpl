<div class="nav">
<a href="index.php"><img src="etoil/logo.png" width="141" height="100" border="0" /></a><br /><br />
<a href="index.php" class="navitem">{tr}Accueil{/tr}</a>
<a href="apropos.php" class="navitem">{tr}A propos d'E-Toil{/tr}</a>
<a href="map.php" class="navitem">{tr}Cartographie{/tr}</a>
<a href="help.php" class="navitem">{tr}Aide{/tr}</a>
<a href="questions.php" class="navitem">{tr}Des questions ?{/tr}</a>
<a href="contact.php" class="navitem">{tr}Contact{/tr}</a>
<br />
{if $smarty.session.me}
<span class="navitem">{tr}Id{/tr}: <b>{$smarty.session.me}</b></span>
<a href="logout.php?from={$smarty.server.PHP_SELF|escape:'url'}" class="navitem">{tr}Quitter{/tr}</a>
{else}
<a href="login.php" class="navitem">{tr}Entrer{/tr}</a>
<a href="register.php" class="navitem">{tr}Nouveau compte{/tr}</a>
{/if}

<div class="cartouche">
<img src="etoil/logo_pract.png" border="0" /><br />
<img src="etoil/mentions_pract.png" border="0" /><br />
<img src="etoil/logo_instit.png" border="0" /><br />
</div>
</div>
