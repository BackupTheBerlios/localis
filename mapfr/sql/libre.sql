# $Id: libre.sql,v 1.1 2002/10/20 13:56:28 mose Exp $
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
  description varchar(255) NOT NULL default '',
  date datetime NOT NULL default '0000-00-00 00:00:00',
  nom varchar(255) NOT NULL default '',
  KEY id (id),
  KEY ville (ville)
) TYPE=MyISAM;

#
# Contenu de la table `firstjeudi`
#

INSERT INTO firstjeudi VALUES (1, 'Aix en Provence', 'Le LUG de la région d\'Aix en Provence organise tous les 4ème mercredi de chaque mois des réunions pour discuter de logiciel libre autour d\'un verre. Cette manifestation est l\'initiative de l\'Axul.', '2002-10-14 13:39:20', 'LUG de la région d\'Aix');
INSERT INTO firstjeudi VALUES (2, 'Auray', 'Le SGEG Meeting a lieu le 3ème mercredi de chaque mois. La première rencontre a eu lieu le 15 Mai et nous nous retrouverons avec plaisir sur les quais de Saint-Goustan à Ti-Morganez  (la petite sirène en breton).', '2002-10-14 13:39:57', 'SGEG Meeting');
INSERT INTO firstjeudi VALUES (3, 'Bordeaux', 'Les Middle Jeudis ont lieu à Bordeaux tous les deuxième jeudi de chaque mois, ils sont organisés par l\'Abul.', '2002-10-14 13:40:14', 'Les Middle Jeudis');
INSERT INTO firstjeudi VALUES (4, 'Digne', 'A Digne ce sont tous les troisième mercredi de chaque mois, que les adhérents de l\'association Linux Alpes vous attendent pour discuter de logiciel libre.', '2002-10-14 13:40:31', 'Linux Alpes');
INSERT INTO firstjeudi VALUES (5, 'Douai', 'A Douai ce sont tous les quatrième mardi de chaque mois, que le CLX vous attends pour discuter de logiciel libre.', '2002-10-14 13:40:45', 'CLX');
INSERT INTO firstjeudi VALUES (6, 'Dunkerque', 'Le troisième mardi de chaque mois, le CLX vous donne rendez-vous à Dunkerque.', '2002-10-14 13:40:55', 'CLX');
INSERT INTO firstjeudi VALUES (7, 'Genève', 'Tous les deuxièmes jeudi de chaque mois, vous avez rendez-vous avec lallg.', '2002-10-14 13:41:12', 'lallg');
INSERT INTO firstjeudi VALUES (8, 'La Rochelle', 'Le premier jeudi de chaque mois, c\'est face à la plage que l\'on discute de logiciel libre avec le Rochelug.', '2002-10-14 13:41:25', 'Rochelug');
INSERT INTO firstjeudi VALUES (9, 'Lille', 'Le deuxième mardi de chaque mois, les amateurs de logiciel libre se retrouve à l\'invitation du CLX.', '2002-10-14 13:41:37', 'CLX');
INSERT INTO firstjeudi VALUES (10, 'Lyon', 'Tous les jeudis l\'ALDIL vous donne rendez-vous à Lyon pour discuter et boire un verre.', '2002-10-14 13:42:24', 'l\'ALDIL');
INSERT INTO firstjeudi VALUES (11, 'Montpellier', 'Les rencontres de Montpellier ont lieu le dernier jeudi  de chaque mois à la Brasserie du Triolet. Cette manifestation est organisée par les membres de l\'ALL', '2002-10-14 13:42:36', 'l\'ALL');
INSERT INTO firstjeudi VALUES (12, 'Paris', 'Les rencontres de Paris ont lieu tous les premiers jeudi de chaque mois à la Taverne des Halles. Chaque mois nous nous retrouvons à une centaine pour discuter de logiciel libre et déguster des préparations houbloniques dans la détente et la bonne humeur.', '2002-10-14 13:42:48', 'Les rencontres de Paris');
INSERT INTO firstjeudi VALUES (13, 'Veynes', 'Les rencontres de Veynes se déroulent tous les quatrièmes mercredi de chaque mois. Elles sont organisées par l\'association Linux Alpes.', '2002-10-14 13:43:29', 'Linux Alpes');
INSERT INTO firstjeudi VALUES (14, 'Veynes', ' Tous les deuxièmes mercredi du mois, venez-donc boire un verre avec les membres de Gulliver ainsi que les autres amateurs de libre de Rennes !', '2002-10-14 13:44:01', 'Gulliver');
# --------------------------------------------------------

#
# Structure de la table `lug`
#

DROP TABLE IF EXISTS lug;
CREATE TABLE lug (
  id int(11) NOT NULL auto_increment,
  ville varchar(255) NOT NULL default '',
  description varchar(255) NOT NULL default '',
  date datetime NOT NULL default '0000-00-00 00:00:00',
  nom varchar(255) NOT NULL default '',
  KEY id (id),
  KEY ville (ville)
) TYPE=MyISAM;

#
# Contenu de la table `lug`
#

INSERT INTO lug VALUES (6, 'caen', 'L\'association CaLviX, le groupe des utilisateurs de Linux et des Logiciels Libre de Caen et du Calvados.', '0000-00-00 00:00:00', 'CaLviX');
INSERT INTO lug VALUES (10, 'Digne', 'Linux Alpes, Association loi 1901 de l\'informatique alternative, Linux et autres . \\n http://www.mairie-dignelesbains.fr/linux-alpes/', '0000-00-00 00:00:00', 'Linux Alpes');
INSERT INTO lug VALUES (7, 'brest', ' L\'association Finix a pour but de faire découvrir et promouvoir les systèmes d\'exploitation Unix gratuits. \\n http://www.finix.eu.org/', '0000-00-00 00:00:00', 'Finix');
INSERT INTO lug VALUES (3, 'biviers', 'GUILDE (Groupement des Utilisateurs Linux du Dauphiné). \\n http://www.guilde.asso.fr/', '0000-00-00 00:00:00', 'Guilde');
INSERT INTO lug VALUES (9, 'Paris', 'Parinux : L.U.G. Paris \\n http://www.parinux.org/', '0000-00-00 00:00:00', 'Parinux');
INSERT INTO lug VALUES (5, 'bordeaux', 'A.B.U.L : Association Bordelaise des Utilisateurs de Linux ABUL S/C CLIA 1,RUE DE CURSOL 33000 BORDEAUX \\n http://www.abul.org/', '0000-00-00 00:00:00', 'ABUL');
INSERT INTO lug VALUES (8, 'Nantes', 'Linux-Nantes : l\'Association des utilisateurs nantais de Linux  \\n http://www.linux-nantes.fr.eu.org/', '0000-00-00 00:00:00', 'Linux-Nantes');
INSERT INTO lug VALUES (11, 'Clermont-Ferrand', 'Linux Arverne est une association créée le 23 octobre 1998 pour promouvoir dans la région Auvergne Linux et les logiciels libres. \\n httphttp://www.linux-arverne.org/', '0000-00-00 00:00:00', 'Linux Arverne');
INSERT INTO lug VALUES (12, 'Cagnes-sur-Mer', ' Cette association a pour but de promouvoir Linux et les Logiciels Libres dans la région de la Côte d\'Azur. \\n httphttp://www.linux-azur.org/', '0000-00-00 00:00:00', 'Linux Azur');
INSERT INTO lug VALUES (13, 'Dijon', 'Le siège de l\'association est situé à Orléans - 4500, dans le département du Loiret. Il pourra être transféré par simple décision du Conseil d\'Administration. \\n http://web.cnrs-orleans.fr/~lugo/', '0000-00-00 00:00:00', 'Coagul');
INSERT INTO lug VALUES (14, 'Marseille', ' Provence Linux Users Group \\n http://www.plugfr.org/', '0000-00-00 00:00:00', 'PLUG');
INSERT INTO lug VALUES (15, 'Caudebec-les-Elbeuf', 'RUNIX est le petit nom du Réseau Haut-Normand pour le Développement de l\'Informatique Libre, une association loi de 1901 dont l\'objectif est de promouvoir les logiciels libres en Haute-Normandie. \\n http://runix.aful.org/', '0000-00-00 00:00:00', 'RUNIX');
INSERT INTO lug VALUES (16, 'Toulouse', 'Club des Utilisateurs de Linux de Toulouse et des environs  \\n http://www.culte.org/', '0000-00-00 00:00:00', 'Culte');
INSERT INTO lug VALUES (17, 'Strasbourg', 'le Groupe des utilisateurs de Linux et de logiciel libre de la région de Strasbourg  \\n http://tux.u-strasbg.fr/', '0000-00-00 00:00:00', 'LUG de Strasbourg');
INSERT INTO lug VALUES (18, 'Poitiers', 'Le GULP est le Groupe des Utilisateurs de Linux à Poitiers.  \\n httphttp://news.pcl.fr/gulp/', '0000-00-00 00:00:00', 'GULP');
INSERT INTO lug VALUES (19, 'vouneuil', 'Association Centre Ouest des Utilisateurs de Logiciels Libres. \\n http://news.pcl.fr/aspic/', '0000-00-00 00:00:00', 'ASPIC');
INSERT INTO lug VALUES (20, 'Chambéry', 'Alpinux est une association loi 1901 qui a pour but \' toutes activités liées au développement, à la production,à la diffusion, à la création, à la promotion des Logiciels Libre. \\n http://www.alpinux.net/', '0000-00-00 00:00:00', 'Alpinux');
INSERT INTO lug VALUES (21, 'Montsalvy', 'Club Informatique Montsalvyen d\'Utilisateurs de Logiciels Libres  \\n http://www.cybercantal.org/cimull/', '0000-00-00 00:00:00', 'Cimull');
INSERT INTO lug VALUES (22, 'Valenciennes', 'Club Linux Nord - Pas de Calais \\n http://clx.anet.fr/spip/', '0000-00-00 00:00:00', 'CLX');
INSERT INTO lug VALUES (23, 'Paris', 'http://gcu-squad.org/', '0000-00-00 00:00:00', 'gcu-squad');
INSERT INTO lug VALUES (24, 'Rambouillet', 'Root66.net est une association de loi 1901 basée dans les yvelines. Elle a pour but de faire découvrir les logiciels libres au public, ainsi que d\'aider toute personne ayant des difficultés dans ce domaine. \\n http://www.root66.net/', '0000-00-00 00:00:00', 'Root66.net');
INSERT INTO lug VALUES (25, 'aix en provence', 'http://www.axul.org/', '0000-00-00 00:00:00', 'Axul');
INSERT INTO lug VALUES (26, 'Metz', ' Le Graoulug est une association à but non lucratif. Elle rassemble tous les passionnés d\'informatique, confirmés ou débutants, qui veulent découvrir et utiliser GNU/Linux ou d\'autres logiciels sous licence libre. \\n httphttp://www.graoulug.org/', '0000-00-00 00:00:00', 'Graoulug');
INSERT INTO lug VALUES (27, 'Nimes', 'Groupe d\' Utilisateurs Linux \\n http://nimes.gul.free.fr/', '0000-00-00 00:00:00', 'nim');
INSERT INTO lug VALUES (28, 'Sarreguemines', 'Mozenix, le Lug de Sarreguemines \\n httphttp://www.mozenix.org/', '0000-00-00 00:00:00', 'Mozenix,');
INSERT INTO lug VALUES (29, 'La Rochelle', 'ROCHELUG, le groupe d\'utilisateurs de linux et des logiciels libres de La Rochelle et ses larges environs. \\n http://lug.larochelle.tuxfamily.org/', '0000-00-00 00:00:00', 'ROCHELUG');
INSERT INTO lug VALUES (30, 'redon', 'La TROLL West (Troupe Redonnaise Orientée Logiciels Libres)  \\n http://troll.west.free.fr/', '0000-00-00 00:00:00', 'TROLL West');
INSERT INTO lug VALUES (31, 'Nancy', 'Groupe des Utilisateurs de Linux de Nancy et ses environs  \\n http://www.mirabellug.fr.fm/', '0000-00-00 00:00:00', 'Mirabellug');
INSERT INTO lug VALUES (32, 'Thones', 'Savoie-Aravis Linux Users Group SALUG est un groupe dutilisateurs de Linux des vallées des Aravis dont lobjet est la promotion des logiciels libres et l\'\'entraide entre les membres. \\n http://salug.tuxfamily.org/', '0000-00-00 00:00:00', 'SALUG');

#
# Structure de la table `trolls`
#

DROP TABLE IF EXISTS trolls;
CREATE TABLE trolls (
  id int(11) NOT NULL auto_increment,
  nom varchar(255) NOT NULL default '',
  email varchar(255) NOT NULL default '',
  description varchar(255) NOT NULL default '',
  date datetime NOT NULL default '0000-00-00 00:00:00',
  KEY id (id),
) TYPE=MyISAM;

#
# Contenu de la table `trolls`
#

INSERT INTO trolls VALUES (1, 'mose', 'mose@localis.org', 'Auteur de Logiciels Libres.', '0000-00-00 00:00:00');
