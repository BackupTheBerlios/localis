{include file="head.tpl"}

<div class="central">
{if $msg eq 'welcome'}
<div>Le compte est enregistré. Vous pouvez maintenant l'utiliser pour vous identifier.</div>
{/if}
<form action="login.php" method="post"  name="login_form">
{tr}Votre login{/tr}<br />
<input type="text" name="login" value="{$login}" id="login" onfocus="this.select()" /><br />
{tr}Votre mot de passe{/tr}<br />
<input type="password" name="pass" value="" onfocus="this.select()" /><br />
<input type="submit" name="act" value="{tr}Login{/tr}" />
</form>
</div>
<script type="text/javascript" language="javascript">
{literal}
<!--
var uname = document.forms['login_form'].elements['login'];
var pword = document.forms['login_form'].elements['pass'];
if (uname.value == '') {
	uname.focus();
} else {
	pword.focus();
}
//-->
{/literal}
</script>


{include file="foot.tpl"}

