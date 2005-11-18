{if $smarty.session.admin}
<a href="admin-users.php" class="adminlink">Users</a>
<a href="admin-conf.php" class="adminlink">Conf</a>
<a href="admin-purge.php?from={$smarty.server.PHP_SELF}" class="adminlink">Purge</a>
<a href="admin-import.php" class="adminlink">Imports</a>
<a href="techdata.php" class="adminlink">Tech Data</a>
{else}
&nbsp;
{/if}
<small>Copyright &copy; e-TOIL 2005 - Site conçu pour un écran configuré en 1024x768 ou plus
et optimisé pour les navigateurs libres <a href="http://www.mozilla.org" target="_blank">Mozilla/Firefox</a> </small>
</td></tr></table>
</body>
</html>
