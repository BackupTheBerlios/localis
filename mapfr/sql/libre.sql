# $Id: libre.sql,v 1.2 2002/10/20 22:39:02 mose Exp $
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
  date datetime NOT NULL default '0000-00-00 00:00:00',
  nom varchar(255) NOT NULL default '',
  email varchar(255) NOT NULL default '',
  url varchar(255) NOT NULL default '',
  KEY id (id),
  KEY ville (ville)
) TYPE=MyISAM;

#
# Contenu de la table `firstjeudi`
#

INSERT INTO firstjeudi VALUES (1, 'Aix en Provence', 'Le LUG de la région d\'Aix en Provence organise tous les 4ème mercredi de chaque mois des réunions pour discuter de logiciel libre autour d\'un verre. Cette manifestation est l\'initiative de l\'Axul.', '2002-10-14 13:39:20', 'LUG de la région d\'Aix','','');
INSERT INTO firstjeudi VALUES (2, 'Auray', 'Le SGEG Meeting a lieu le 3ème mercredi de chaque mois. La première rencontre a eu lieu le 15 Mai et nous nous retrouverons avec plaisir sur les quais de Saint-Goustan à Ti-Morganez  (la petite sirène en breton).', '2002-10-14 13:39:57', 'SGEG Meeting','','');
INSERT INTO firstjeudi VALUES (3, 'Bordeaux', 'Les Middle Jeudis ont lieu à Bordeaux tous les deuxième jeudi de chaque mois, ils sont organisés par l\'Abul.', '2002-10-14 13:40:14', 'Les Middle Jeudis','','');
INSERT INTO firstjeudi VALUES (4, 'Digne', 'A Digne ce sont tous les troisième mercredi de chaque mois, que les adhérents de l\'association Linux Alpes vous attendent pour discuter de logiciel libre.', '2002-10-14 13:40:31', 'Linux Alpes','','');
INSERT INTO firstjeudi VALUES (5, 'Douai', 'A Douai ce sont tous les quatrième mardi de chaque mois, que le CLX vous attends pour discuter de logiciel libre.', '2002-10-14 13:40:45', 'CLX','','');
INSERT INTO firstjeudi VALUES (6, 'Dunkerque', 'Le troisième mardi de chaque mois, le CLX vous donne rendez-vous à Dunkerque.', '2002-10-14 13:40:55', 'CLX','','');
INSERT INTO firstjeudi VALUES (7, 'Genève', 'Tous les deuxièmes jeudi de chaque mois, vous avez rendez-vous avec lallg.', '2002-10-14 13:41:12', 'lallg','','');
INSERT INTO firstjeudi VALUES (8, 'La Rochelle', 'Le premier jeudi de chaque mois, c\'est face à la plage que l\'on discute de logiciel libre avec le Rochelug.', '2002-10-14 13:41:25', 'Rochelug','','');
INSERT INTO firstjeudi VALUES (9, 'Lille', 'Le deuxième mardi de chaque mois, les amateurs de logiciel libre se retrouve à l\'invitation du CLX.', '2002-10-14 13:41:37', 'CLX','','');
INSERT INTO firstjeudi VALUES (10, 'Lyon', 'Tous les jeudis l\'ALDIL vous donne rendez-vous à Lyon pour discuter et boire un verre.', '2002-10-14 13:42:24', 'l\'ALDIL','','');
INSERT INTO firstjeudi VALUES (11, 'Montpellier', 'Les rencontres de Montpellier ont lieu le dernier jeudi  de chaque mois à la Brasserie du Triolet. Cette manifestation est organisée par les membres de l\'ALL', '2002-10-14 13:42:36', 'l\'ALL','','');
INSERT INTO firstjeudi VALUES (12, 'Paris', 'Les rencontres de Paris ont lieu tous les premiers jeudi de chaque mois à la Taverne des Halles. Chaque mois nous nous retrouvons à une centaine pour discuter de logiciel libre et déguster des préparations houbloniques dans la détente et la bonne humeur.', '2002-10-14 13:42:48', 'Les rencontres de Paris','','');
INSERT INTO firstjeudi VALUES (13, 'Veynes', 'Les rencontres de Veynes se déroulent tous les quatrièmes mercredi de chaque mois. Elles sont organisées par l\'association Linux Alpes.', '2002-10-14 13:43:29', 'Linux Alpes','','');
INSERT INTO firstjeudi VALUES (14, 'Veynes', ' Tous les deuxièmes mercredi du mois, venez-donc boire un verre avec les membres de Gulliver ainsi que les autres amateurs de libre de Rennes !', '2002-10-14 13:44:01', 'Gulliver','','');
# --------------------------------------------------------

#
# Structure de la table `lug`
#

DROP TABLE IF EXISTS lug;
CREATE TABLE lug (
  id int(11) NOT NULL auto_increment,
  ville varchar(255) NOT NULL default '',
  notes varchar(255) NOT NULL default '',
  date datetime NOT NULL default '0000-00-00 00:00:00',
  nom varchar(255) NOT NULL default '',
  email varchar(255) NOT NULL default '',
  url varchar(255) NOT NULL default '',
  PRIMARY KEY id (id)
) TYPE=MyISAM;

#
# Contenu de la table `lug`
#

INSERT INTO lug VALUES (1, 'caen', 'Groupe des utilisateurs de Linux et des Logiciels Libre de Caen et du Calvados.', '0000-00-00 00:00:00', 'CaLviX','','');
INSERT INTO lug VALUES (2, 'Digne', 'Informatique alternative, Linux et autres.', '0000-00-00 00:00:00', 'Linux Alpes','','http://www.mairie-dignelesbains.fr/linux-alpes');
INSERT INTO lug VALUES (3, 'brest', 'Faire découvrir et promouvoir les systèmes d\'exploitation Unix gratuits.', '0000-00-00 00:00:00', 'Finix','','http://www.finix.eu.org');
INSERT INTO lug VALUES (4, 'biviers', 'Groupement des Utilisateurs Linux du Dauphiné.', '0000-00-00 00:00:00', 'Guilde','','http://www.guilde.asso.fr');
INSERT INTO lug VALUES (5, 'Paris', 'L.U.G. Paris.', '0000-00-00 00:00:00', 'Parinux','','http://www.parinux.org');
INSERT INTO lug VALUES (6, 'bordeaux', 'Association Bordelaise des Utilisateurs de Linux.', '0000-00-00 00:00:00', 'ABUL','','http://www.abul.org');
INSERT INTO lug VALUES (7, 'Nantes', 'Association des utilisateurs nantais de Linux.', '0000-00-00 00:00:00', 'Linux-Nantes','','http://www.linux-nantes.fr.eu.org');
INSERT INTO lug VALUES (11, 'Clermont-Ferrand', 'Promouvoir dans la région Auvergne Linux et les logiciels libres.', '0000-00-00 00:00:00', 'Linux Arverne','','http://www.linux-arverne.org');
INSERT INTO lug VALUES (12, 'Cagnes-sur-Mer', 'Promouvoir Linux et les Logiciels Libres dans la région de la Côte d\'Azur.', '0000-00-00 00:00:00', 'Linux Azur','','http://www.linux-azur.org');
INSERT INTO lug VALUES (13, 'Orléans', 'Association à Orléans, dans le département du Loiret.', '0000-00-00 00:00:00', 'Coagul','','http://web.cnrs-orleans.fr/~lugo');
INSERT INTO lug VALUES (14, 'Marseille', ' Provence Linux Users Group.', '0000-00-00 00:00:00', 'PLUG','','http://www.plugfr.org');
INSERT INTO lug VALUES (15, 'Caudebec-les-Elbeuf', 'Réseau Haut-Normand pour le Développement de l\'Informatique Libre.', '0000-00-00 00:00:00', 'RUNIX','','http://runix.aful.org');
INSERT INTO lug VALUES (16, 'Toulouse', 'Club des Utilisateurs de Linux de Toulouse et des environs.', '0000-00-00 00:00:00', 'Culte','','http://www.culte.org');
INSERT INTO lug VALUES (17, 'Strasbourg', 'Groupe des utilisateurs de Linux et de logiciel libre de la région de Strasbourg.', '0000-00-00 00:00:00', 'LUG de Strasbourg','','http://tux.u-strasbg.fr');
INSERT INTO lug VALUES (18, 'Poitiers', 'Groupe des Utilisateurs de Linux à Poitiers.', '0000-00-00 00:00:00', 'GULP','','http://news.pcl.fr/gulp');
INSERT INTO lug VALUES (19, 'vouneuil', 'Association Centre Ouest des Utilisateurs de Logiciels Libres.', '0000-00-00 00:00:00', 'ASPIC','','http://news.pcl.fr/aspic');
INSERT INTO lug VALUES (20, 'Chambéry', 'Logiciels Libre dans les Alpes.', '0000-00-00 00:00:00', 'Alpinux','','http://www.alpinux.net');
INSERT INTO lug VALUES (21, 'Montsalvy', 'Club Informatique Montsalvyen d\'Utilisateurs de Logiciels Libres.', '0000-00-00 00:00:00', 'Cimull','','http://www.cybercantal.org/cimull');
INSERT INTO lug VALUES (22, 'Valenciennes', 'Club Linux Nord - Pas de Calais.', '0000-00-00 00:00:00', 'CLX','','http://clx.anet.fr/spip');
INSERT INTO lug VALUES (23, 'Paris', 'Gorupe parisien', '0000-00-00 00:00:00', 'GCU-squad','','http://gcu-squad.org');
INSERT INTO lug VALUES (24, 'Rambouillet', 'Faire découvrir les logiciels libres au public en Yvelines.', '0000-00-00 00:00:00', 'Root66.net','','http://www.root66.net');
INSERT INTO lug VALUES (25, 'aix en provence', 'lug', '0000-00-00 00:00:00', 'Axul','','http://www.axul.org');
INSERT INTO lug VALUES (26, 'Metz', 'Découvrir et utiliser GNU/Linux et d\'autres logiciels sous licence libre.', '0000-00-00 00:00:00', 'Graoulug','','http://www.graoulug.org');
INSERT INTO lug VALUES (27, 'Nimes', 'Groupe d\' Utilisateurs Linux Nimois.', '0000-00-00 00:00:00', 'nim','','http://nimes.gul.free.fr');
INSERT INTO lug VALUES (28, 'Sarreguemines', 'Lug de Sarreguemines.', '0000-00-00 00:00:00', 'Mozenix,','','http://www.mozenix.org');
INSERT INTO lug VALUES (29, 'La Rochelle', 'Groupe d\'utilisateurs de linux et des logiciels libres de La Rochelle et ses larges environs.', '0000-00-00 00:00:00', 'ROCHELUG','','http://lug.larochelle.tuxfamily.org');
INSERT INTO lug VALUES (30, 'redon', 'Troupe Redonnaise Orientée Logiciels Libres.', '0000-00-00 00:00:00', 'TROLL West','','http://troll.west.free.fr');
INSERT INTO lug VALUES (31, 'Nancy', 'Groupe des Utilisateurs de Linux de Nancy et ses environs.', '0000-00-00 00:00:00', 'Mirabellug','','http://www.mirabellug.fr.fm');
INSERT INTO lug VALUES (32, 'Thones', 'Savoie-Aravis Linux Users Group.', '0000-00-00 00:00:00', 'SALUG','','http://salug.tuxfamily.org');

#
# Structure de la table `trolls`
#

DROP TABLE IF EXISTS trolls;
CREATE TABLE trolls (
  id int(11) NOT NULL auto_increment,
  ville varchar(255) NOT NULL default '',
  notes varchar(255) NOT NULL default '',
  date datetime NOT NULL default '0000-00-00 00:00:00',
  nom varchar(255) NOT NULL default '',
  email varchar(255) NOT NULL default '',
  url varchar(255) NOT NULL default '',
  PRIMARY KEY id (id)
) TYPE=MyISAM;

#
# Contenu de la table `trolls`
#

INSERT INTO trolls VALUES (1, 'paris', 'Auteur de Logiciels Libres.', '', 'mose', 'mose@localis.org', 'http://mose.com');
