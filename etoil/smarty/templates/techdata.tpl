{include file="head.tpl"}

<div class="central">

<h2>Installation</h2>
<h3>Serveur</h3>
<ul>
<li>PostgreSQL 7.4.7</li>
<li>Postgis 1.0.0RC2</li>
<li>Mapserver 4.2.2</li>
<li>GDAL 1.2.1</li>
<li>PHP 4.3.8</li>
</ul>
Postgres et postgis sont installés à partir du tarball dans /usr/local/psql. <br />
Mapserver, GDAL et php sont installés à l'aide du script easymapserver v0.5 en ajoutant dans PHPOPTION --with-pgsql, et dans MAPSERVEROPTIONS
--with-postgis.<br />
Apache est installé sur mon systeme en debian sid version 1.3.33<br />

<h3>E-toil</h3>
Décompressez e-toil-**.tar.gz dans, par exemple /usr/local/etoil.<br />
Smarty est integré dans e-toil et ne demande pas d'installation séparée.
<br /><br />

<h2>Configuration</h2>
<h3>Apache</h3>
<pre>&lt;VirtualHost *&gt;
  ServerName e.toil                    # faux nom ajouté dans /etc/hosts pour un accès strictement local
  DocumentRoot /usr/local/etoil/www    # ajuster selon l'endroit ou e-toil est installé
  Alias /maps/ /usr/local/etoil/maps/  # idem
  Options +FollowSymLinks
  DirectoryIndex index.php
  AddType application/php-cgi .php
  Action application/php-cgi /cgi-bin/php
  ErrorLog /var/log/apache/etoil-error_log
  Customlog /var/log/apache/etoil-access_log combined
  ScriptAlias /cgi-bin/ "/usr/local/mapserver/cgi-bin/"
&lt;/VirtualHost&gt;
</pre>
<br /><br />

<h2>Operations</h2>
Pour lancer PostgreSQL<br />
<tt>sudo -u postgres /usr/local/pgsql/bin/pg_ctl -D /usr/local/pgsql/data/ start</tt><br />
<br /><br />


<div>

{include file="foot.tpl"}
