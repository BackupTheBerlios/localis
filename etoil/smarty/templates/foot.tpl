</td>
<td class="leftbar">
&nbsp;
</td></tr>
<tr>
<td colspan="2" align="right" class="bottomline">
{if $smarty.session.admin}
<a href="admin-users.php" class="adminlink">Users</a>
<a href="admin-conf.php" class="adminlink">Conf</a>
<a href="admin-purge.php?from={$smarty.server.PHP_SELF}" class="adminlink">Purge</a>
<a href="techdata.php" class="adminlink">Tech Data</a>
{else}
&nbsp;
{/if}Copyright &copy; e-TOIL 2005 - Site conçu pour un écran configuré en 1024x768 ou plus
</td></tr></table>
</td></tr></table>
</body>
</html>
