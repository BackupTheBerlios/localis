# phpMyAdmin MySQL-Dump
# version 2.3.2
# http://www.phpmyadmin.net/ (download page)
#
# Serveur: localhost
# Généré le : Mardi 15 Octobre 2002 à 16:24
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
  KEY id (id),
  KEY ville (ville)
) TYPE=MyISAM;

#
# Contenu de la table `firstjeudi`
#

INSERT INTO firstjeudi VALUES (1, 'Aix en Provence', 'Le LUG de la région d\'Aix en Provence organise tous les 4ème mercredi de chaque mois des réunions pour discuter de logiciel libre autour d\'un verre. Cette manifestation est l\'initiative de l\'Axul.', '2002-10-14 13:39:20');
INSERT INTO firstjeudi VALUES (2, 'Auray', 'Le SGEG Meeting a lieu le 3ème mercredi de chaque mois. La première rencontre a eu lieu le 15 Mai et nous nous retrouverons avec plaisir sur les quais de Saint-Goustan à Ti-Morganez  (la petite sirène en breton).', '2002-10-14 13:39:57');
INSERT INTO firstjeudi VALUES (3, 'Bordeaux', 'Les Middle Jeudis ont lieu à Bordeaux tous les deuxième jeudi de chaque mois, ils sont organisés par l\'Abul.', '2002-10-14 13:40:14');
INSERT INTO firstjeudi VALUES (4, 'Digne', 'A Digne ce sont tous les troisième mercredi de chaque mois, que les adhérents de l\'association Linux Alpes vous attendent pour discuter de logiciel libre.', '2002-10-14 13:40:31');
INSERT INTO firstjeudi VALUES (5, 'Douai', 'A Douai ce sont tous les quatrième mardi de chaque mois, que le CLX vous attends pour discuter de logiciel libre.', '2002-10-14 13:40:45');
INSERT INTO firstjeudi VALUES (6, 'Dunkerque', 'Le troisième mardi de chaque mois, le CLX vous donne rendez-vous à Dunkerque.', '2002-10-14 13:40:55');
INSERT INTO firstjeudi VALUES (7, 'Genève', 'Tous les deuxièmes jeudi de chaque mois, vous avez rendez-vous avec lallg.', '2002-10-14 13:41:12');
INSERT INTO firstjeudi VALUES (8, 'La Rochelle', 'Le premier jeudi de chaque mois, c\'est face à la plage que l\'on discute de logiciel libre avec le Rochelug.', '2002-10-14 13:41:25');
INSERT INTO firstjeudi VALUES (9, 'Lille', 'Le deuxième mardi de chaque mois, les amateurs de logiciel libre se retrouve à l\'invitation du CLX.', '2002-10-14 13:41:37');
INSERT INTO firstjeudi VALUES (10, 'Lyon', 'Tous les jeudis l\'ALDIL vous donne rendez-vous à Lyon pour discuter et boire un verre.', '2002-10-14 13:42:24');
INSERT INTO firstjeudi VALUES (11, 'Montpellier', 'Les rencontres de Montpellier ont lieu le dernier jeudi  de chaque mois à la Brasserie du Triolet. Cette manifestation est organisée par les membres de l\'ALL', '2002-10-14 13:42:36');
INSERT INTO firstjeudi VALUES (12, 'Paris', 'Les rencontres de Paris ont lieu tous les premiers jeudi de chaque mois à la Taverne des Halles. Chaque mois nous nous retrouvons à une centaine pour discuter de logiciel libre et déguster des préparations houbloniques dans la détente et la bonne humeur.', '2002-10-14 13:42:48');
INSERT INTO firstjeudi VALUES (13, 'Veynes', 'Les rencontres de Veynes se déroulent tous les quatrièmes mercredi de chaque mois. Elles sont organisées par l\'association Linux Alpes.', '2002-10-14 13:43:29');
INSERT INTO firstjeudi VALUES (14, 'Veynes', ' Tous les deuxièmes mercredi du mois, venez-donc boire un verre avec les membres de Gulliver ainsi que les autres amateurs de libre de Rennes !', '2002-10-14 13:44:01');

