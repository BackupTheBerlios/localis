# $Id: libre.sql,v 1.6 2002/10/21 14:47:55 mose Exp $
#
# Serveur: localhost
# Généré le : Jeudi 17 Octobre 2002 à 15:10
# Version du serveur: 3.23.52
# Version de PHP: 4.2.3
# Base de données: `evenements`
# --------------------------------------------------------

#
# Structure de la table `firstjeudi`
#

DROP TABLE IF EXISTS firstjeudi;
CREATE TABLE firstjeudi (
  id int(11) NOT NULL auto_increment,
  ville varchar(255) NOT NULL default '',
  notes varchar(255) NOT NULL default '',
  date datetime NOT NULL,
  nom varchar(255) NOT NULL default '',
  email varchar(255) NOT NULL default '',
  url varchar(255) NOT NULL default '',
	verified enum('0','1') NOT NULL default '0',
  PRIMARY KEY id (id)
) TYPE=MyISAM;

#
# Contenu de la table `firstjeudi`
#

INSERT INTO firstjeudi VALUES (1, 'Aix en Provence', 'Tous les 4ème mercredi de chaque mois, initiative de l\'Axul.', '2002-10-14 13:39:20', 'LUG de la région d\'Aix','','http://aix-en-provence.firstjeudi.org/','1');
INSERT INTO firstjeudi VALUES (2, 'Auray', 'Le 3ème mercredi de chaque mois, sur les quais de Saint-Goustan à Ti-Morganez  (la petite sirène en breton).', '2002-10-14 13:39:57', 'SGEG Meeting','','http://auray.firstjeudi.org/','1');
INSERT INTO firstjeudi VALUES (3, 'Bordeaux', 'Tous les deuxième jeudi de chaque mois, ils sont organisés par l\'Abul.', '2002-10-14 13:40:14', 'Les Middle Jeudis','','http://bordeaux.firstjeudi.org/','1');
INSERT INTO firstjeudi VALUES (4, 'Digne', 'Tous les troisième mercredi de chaque mois, Association Linux Alpes.', '2002-10-14 13:40:31', 'Linux Alpes','','http://digne.firstjeudi.org/','1');
INSERT INTO firstjeudi VALUES (5, 'Douai', 'Tous les quatrième mardi de chaque mois, organisé par le CLX.', '2002-10-14 13:40:45', 'CLX','','http://douai.firstjeudi.org/','1');
INSERT INTO firstjeudi VALUES (6, 'Dunkerque', 'Le troisième mardi de chaque mois, organisé par le CLX.', '2002-10-14 13:40:55', 'CLX','','http://dunkerque.firstjeudi.org/','1');
INSERT INTO firstjeudi VALUES (8, 'La Rochelle', 'Le premier jeudi de chaque mois, face à la plage avec le Rochelug.', '2002-10-14 13:41:25', 'Rochelug','','http://larochelle.firstjeudi.org/','1');
INSERT INTO firstjeudi VALUES (9, 'Lille', 'Le deuxième mardi de chaque mois, à l\'invitation du CLX.', '2002-10-14 13:41:37', 'CLX','','http://lille.firstjeudi.org/','1');
INSERT INTO firstjeudi VALUES (10, 'Lyon', 'Tous les jeudis l\'ALDIL vous donne rendez-vous à Lyon pour discuter et boire un verre.', '2002-10-14 13:42:24', 'l\'ALDIL','','http://lyon.firstjeudi.org/','1');
INSERT INTO firstjeudi VALUES (11, 'Montpellier', 'Le dernier jeudi  de chaque mois à la Brasserie du Triolet, organisée par les membres de l\'ALL', '2002-10-14 13:42:36', 'l\'ALL','','http://montpellier.firstjeudi.org/','1');
INSERT INTO firstjeudi VALUES (12, 'Paris', 'Tous les premiers jeudi de chaque mois à la Taverne des Halles.', '2002-10-14 13:42:48', 'Les rencontres de Paris','','http://paris.firstjeudi.org/','1');
INSERT INTO firstjeudi VALUES (13, 'Veynes', 'Tous les quatrièmes mercredi de chaque mois, organisées par Linux Alpes.', '2002-10-14 13:43:29', 'Linux Alpes','','http://veynes.firstjeudi.org/','1');
INSERT INTO firstjeudi VALUES (14, 'Rennes', ' Tous les deuxièmes mercredi du mois, avec les membres de Gulliver.', '2002-10-14 13:44:01', 'Gulliver','','http://rennes.firstjeudi.org/','1');
# --------------------------------------------------------

#
# Structure de la table `lug`
#

DROP TABLE IF EXISTS lug;
CREATE TABLE lug (
  id int(11) NOT NULL auto_increment,
  ville varchar(255) NOT NULL default '',
  notes varchar(255) NOT NULL default '',
  date datetime NOT NULL,
  nom varchar(255) NOT NULL default '',
  email varchar(255) NOT NULL default '',
  url varchar(255) NOT NULL default '',
	verified enum('0','1') NOT NULL default '0',
  PRIMARY KEY id (id)
) TYPE=MyISAM;

#
# Contenu de la table `lug`
#

INSERT INTO lug VALUES (1, 'Caen', 'Groupe des utilisateurs de Linux et des Logiciels Libre de Caen et du Calvados.', '0000-00-00 00:00:00', 'CaLviX','','','1');
INSERT INTO lug VALUES (2, 'Digne', 'Informatique alternative, Linux et autres.', '0000-00-00 00:00:00', 'Linux Alpes','','http://www.mairie-dignelesbains.fr/linux-alpes','1');
INSERT INTO lug VALUES (3, 'Brest', 'Faire découvrir et promouvoir les systèmes d\'exploitation Unix gratuits.', '0000-00-00 00:00:00', 'Finix','','http://www.finix.eu.org','1');
INSERT INTO lug VALUES (4, 'Biviers', 'Groupement des Utilisateurs Linux du Dauphiné.', '0000-00-00 00:00:00', 'Guilde','','http://www.guilde.asso.fr','1');
INSERT INTO lug VALUES (5, 'Paris', 'L.U.G. Paris.', '0000-00-00 00:00:00', 'Parinux','','http://www.parinux.org','1');
INSERT INTO lug VALUES (6, 'Bordeaux', 'Association Bordelaise des Utilisateurs de Linux.', '0000-00-00 00:00:00', 'ABUL','','http://www.abul.org','1');
INSERT INTO lug VALUES (7, 'Nantes', 'Association des utilisateurs nantais de Linux.', '0000-00-00 00:00:00', 'Linux-Nantes','','http://www.linux-nantes.fr.eu.org','1');
INSERT INTO lug VALUES (11, 'Clermont-Ferrand', 'Promouvoir dans la région Auvergne Linux et les logiciels libres.', '0000-00-00 00:00:00', 'Linux Arverne','','http://www.linux-arverne.org','1');
INSERT INTO lug VALUES (12, 'Cagnes-sur-Mer', 'Promouvoir Linux et les Logiciels Libres dans la région de la Côte d\'Azur.', '0000-00-00 00:00:00', 'Linux Azur','','http://www.linux-azur.org','1');
INSERT INTO lug VALUES (13, 'Orléans', 'Association à Orléans, dans le département du Loiret.', '0000-00-00 00:00:00', 'Coagul','','http://web.cnrs-orleans.fr/~lugo','1');
INSERT INTO lug VALUES (14, 'Marseille', ' Provence Linux Users Group.', '0000-00-00 00:00:00', 'PLUG','','http://www.plugfr.org','1');
INSERT INTO lug VALUES (15, 'Caudebec-les-Elbeuf', 'Réseau Haut-Normand pour le Développement de l\'Informatique Libre.', '0000-00-00 00:00:00', 'RUNIX','','http://runix.aful.org','1');
INSERT INTO lug VALUES (16, 'Toulouse', 'Club des Utilisateurs de Linux de Toulouse et des environs.', '0000-00-00 00:00:00', 'Culte','','http://www.culte.org','1');
INSERT INTO lug VALUES (17, 'Strasbourg', 'Groupe des utilisateurs de Linux et de logiciel libre de la région de Strasbourg.', '0000-00-00 00:00:00', 'LUG de Strasbourg','','http://tux.u-strasbg.fr','1');
INSERT INTO lug VALUES (18, 'Poitiers', 'Groupe des Utilisateurs de Linux à Poitiers.', '0000-00-00 00:00:00', 'GULP','','http://news.pcl.fr/gulp','1');
INSERT INTO lug VALUES (19, 'Vouneuil', 'Association Centre Ouest des Utilisateurs de Logiciels Libres.', '0000-00-00 00:00:00', 'ASPIC','','http://news.pcl.fr/aspic','1');
INSERT INTO lug VALUES (20, 'Chambéry', 'Logiciels Libre dans les Alpes.', '0000-00-00 00:00:00', 'Alpinux','','http://www.alpinux.net','1');
INSERT INTO lug VALUES (21, 'Montsalvy', 'Club Informatique Montsalvyen d\'Utilisateurs de Logiciels Libres.', '0000-00-00 00:00:00', 'Cimull','','http://www.cybercantal.org/cimull','1');
INSERT INTO lug VALUES (22, 'Valenciennes', 'Club Linux Nord - Pas de Calais.', '0000-00-00 00:00:00', 'CLX','','http://clx.anet.fr/spip','1');
INSERT INTO lug VALUES (23, 'Paris', 'Gorupe parisien', '0000-00-00 00:00:00', 'GCU-squad','','http://gcu-squad.org','1');
INSERT INTO lug VALUES (24, 'Rambouillet', 'Faire découvrir les logiciels libres au public en Yvelines.', '0000-00-00 00:00:00', 'Root66.net','','http://www.root66.net','1');
INSERT INTO lug VALUES (25, 'Aix en provence', 'lug', '0000-00-00 00:00:00', 'Axul','','http://www.axul.org','1');
INSERT INTO lug VALUES (26, 'Metz', 'Découvrir et utiliser GNU/Linux et d\'autres logiciels sous licence libre.', '0000-00-00 00:00:00', 'Graoulug','','http://www.graoulug.org','1');
INSERT INTO lug VALUES (27, 'Nimes', 'Groupe d\' Utilisateurs Linux Nimois.', '0000-00-00 00:00:00', 'nim','','http://nimes.gul.free.fr','1');
INSERT INTO lug VALUES (28, 'Sarreguemines', 'Lug de Sarreguemines.', '0000-00-00 00:00:00', 'Mozenix,','','http://www.mozenix.org','1');
INSERT INTO lug VALUES (29, 'La Rochelle', 'Groupe d\'utilisateurs de linux et des logiciels libres de La Rochelle et ses larges environs.', '0000-00-00 00:00:00', 'ROCHELUG','','http://lug.larochelle.tuxfamily.org','1');
INSERT INTO lug VALUES (30, 'Redon', 'Troupe Redonnaise Orientée Logiciels Libres.', '0000-00-00 00:00:00', 'TROLL West','','http://troll.west.free.fr','1');
INSERT INTO lug VALUES (31, 'Nancy', 'Groupe des Utilisateurs de Linux de Nancy et ses environs.', '0000-00-00 00:00:00', 'Mirabellug','','http://www.mirabellug.fr.fm','1');
INSERT INTO lug VALUES (32, 'Thones', 'Savoie-Aravis Linux Users Group.', '0000-00-00 00:00:00', 'SALUG','','http://salug.tuxfamily.org','1');

#
# Structure de la table `trolls`
#

DROP TABLE IF EXISTS trolls;
CREATE TABLE trolls (
  id int(11) NOT NULL auto_increment,
  ville varchar(255) NOT NULL default '',
  notes varchar(255) NOT NULL default '',
  date datetime NOT NULL,
  nom varchar(255) NOT NULL default '',
  email varchar(255) NOT NULL default '',
  url varchar(255) NOT NULL default '',
	verified enum('0','1') NOT NULL default '0',
  PRIMARY KEY id (id)
) TYPE=MyISAM;

#
# Contenu de la table `trolls`
#

INSERT INTO trolls VALUES (1, 'Paris', 'Auteur de Logiciels Libres.', '', 'mose', 'mose@localis.org', 'http://mose.com','1');
INSERT INTO trolls VALUES (2, 'Saint-maur-des-fosses', 'Codeur corse.', '', 'mastre', 'mastre@localis.org', 'http://beve.org','1');
INSERT INTO trolls VALUES (3, 'Auray', 'Travailleur indépendant.', '', 'rodolphe', 'rq@lolix.org', 'http://lolix.org','1');
INSERT INTO trolls VALUES (4, 'Paris', 'Travailleur indépendant.', '', 'shinobi', 'arnaud@crao.net', 'http://crao.net','1');


#
# Structure de la table `human`
#

DROP TABLE IF EXISTS human;
CREATE TABLE human (
  id int(11) NOT NULL auto_increment,
  ville varchar(255) NOT NULL default '',
  notes varchar(255) NOT NULL default '',
  date datetime NOT NULL,
  nom varchar(255) NOT NULL default '',
  email varchar(255) NOT NULL default '',
  url varchar(255) NOT NULL default '',
	verified enum('0','1') NOT NULL default '0',
  PRIMARY KEY id (id)
) TYPE=MyISAM;

#
# Contenu de la table `human`
#

INSERT INTO human VALUES (1, 'Le-Haillan', 'Médias-Cité', '', 'Gerald Elbaze', '', 'http://medias-cite.org','1');
INSERT INTO human VALUES (2, 'Saint-Martin-de-Ré', 'Ré-publique et RadioPhare', '', 'Olivier Zablocki', '', 'http://re-publique.net','1');

