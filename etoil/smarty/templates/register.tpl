{include file="head.tpl"}

<div class="central">
<form action="register.php" method="post">
<table>
<tr><td>{tr}Votre login{/tr}</td><td><input type="text" name="login" value="{$f.login}" /></td></tr>
<tr><td>{tr}Choisissez un mot de passe{/tr}</td><td><input type="password" name="pass1" value="" /></td></tr>
<tr><td>{tr}... et retapez-le{/tr}</td><td><input type="password" name="pass2" value="" /></td></tr>
<tr><td>{tr}Votre email{/tr}</td><td><input type="text" name="email" value="{$f.email}" /></td></tr>
<tr><td>{tr}Commentaires{/tr}</td><td><textarea cols="60" rows="10" name="bio">{$f.bio}</textarea></td></tr>
<tr><td>&nbsp;</td><td><input type="submit" name="act" value="{tr}Envoyer{/tr}" /></td></tr>
</table>
</form>
</div>

{include file="foot.tpl"}
