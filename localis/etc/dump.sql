# phpMyAdmin MySQL-Dump
# version 2.3.3pl1
# http://www.phpmyadmin.net/ (download page)
#
# Host: localhost
# Generation Time: Mar 26, 2003 at 09:16 PM
# Server version: 3.23.55
# PHP Version: 4.2.3
# Database : `localis_radiophare`
# --------------------------------------------------------

#
# Table structure for table `dots`
#

DROP TABLE IF EXISTS dots;
CREATE TABLE dots (
  id int(11) NOT NULL auto_increment,
  E int(11) NOT NULL default '0',
  N int(11) NOT NULL default '0',
  Z int(11) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM COMMENT='Coordinates of elementary dots';

#
# Dumping data for table `dots`
#

INSERT INTO dots VALUES (1, 314552, 2140576, 0);
INSERT INTO dots VALUES (2, 303104, 2141572, 0);
INSERT INTO dots VALUES (3, 314249, 2140686, 0);
INSERT INTO dots VALUES (4, 315383, 2138942, 0);
INSERT INTO dots VALUES (5, 309231, 2141116, 0);
INSERT INTO dots VALUES (6, 314249, 2140686, 0);
INSERT INTO dots VALUES (7, 314890, 2136740, 0);
INSERT INTO dots VALUES (8, 317308, 2134878, 0);
INSERT INTO dots VALUES (9, 317308, 2134878, 0);
INSERT INTO dots VALUES (10, 317473, 2138628, 0);
INSERT INTO dots VALUES (11, 317063, 2138166, 0);
INSERT INTO dots VALUES (12, 321108, 2135205, 0);
INSERT INTO dots VALUES (13, 315409, 2139420, 0);
INSERT INTO dots VALUES (14, 312382, 2138889, 0);
INSERT INTO dots VALUES (15, 309583, 2139415, 0);
INSERT INTO dots VALUES (16, 302339, 2141392, 0);
INSERT INTO dots VALUES (17, 308849, 2142568, 0);
INSERT INTO dots VALUES (18, 655078, 2179887, 0);
# --------------------------------------------------------

#
# Table structure for table `layer`
#

DROP TABLE IF EXISTS layer;
CREATE TABLE layer (
  layerid int(11) NOT NULL auto_increment,
  layername varchar(255) default NULL,
  layertype enum('point','line') default NULL,
  layergroup varchar(255) default NULL,
  layercolor varchar(255) default NULL,
  layersize tinyint(4) default NULL,
  layersymbol varchar(255) default NULL,
  layermeta int(11) unsigned default NULL,
  PRIMARY KEY  (layerid)
) TYPE=MyISAM;

#
# Dumping data for table `layer`
#

INSERT INTO layer VALUES (5, '4. Gros besoin de connexion', 'point', '', '', 0, 'troll', NULL);
INSERT INTO layer VALUES (3, '2. Annuaire', 'point', '', '', 0, 'tux', NULL);
INSERT INTO layer VALUES (4, '3. Point d\'accès', 'point', '', '', 0, 'ordi', NULL);
INSERT INTO layer VALUES (8, '5. Présence de Logiciels Libres', 'point', '', '', 0, 'tux', NULL);
INSERT INTO layer VALUES (9, '1. Contribution', 'point', '', '', 0, 'flagblue', NULL);
INSERT INTO layer VALUES (11, '6. Materiel telecom', 'point', '', '', 0, 'ordi', NULL);
# --------------------------------------------------------

#
# Table structure for table `layerobj`
#

DROP TABLE IF EXISTS layerobj;
CREATE TABLE layerobj (
  objectid int(11) NOT NULL default '0',
  layerid int(11) NOT NULL default '0',
  ranknum int(11) NOT NULL default '0',
  PRIMARY KEY  (layerid,objectid,ranknum)
) TYPE=MyISAM;

#
# Dumping data for table `layerobj`
#

INSERT INTO layerobj VALUES (1, 1, 0);
INSERT INTO layerobj VALUES (3, 4, 0);
INSERT INTO layerobj VALUES (4, 4, 0);
INSERT INTO layerobj VALUES (6, 4, 0);
INSERT INTO layerobj VALUES (2, 5, 0);
INSERT INTO layerobj VALUES (5, 9, 0);
INSERT INTO layerobj VALUES (19, 9, 0);
INSERT INTO layerobj VALUES (7, 10, 0);
INSERT INTO layerobj VALUES (9, 11, 0);
INSERT INTO layerobj VALUES (10, 11, 0);
INSERT INTO layerobj VALUES (11, 11, 0);
INSERT INTO layerobj VALUES (12, 11, 0);
INSERT INTO layerobj VALUES (13, 11, 0);
INSERT INTO layerobj VALUES (14, 11, 0);
INSERT INTO layerobj VALUES (15, 11, 0);
INSERT INTO layerobj VALUES (16, 11, 0);
INSERT INTO layerobj VALUES (17, 11, 0);
INSERT INTO layerobj VALUES (18, 11, 0);
# --------------------------------------------------------

#
# Table structure for table `metadata`
#

DROP TABLE IF EXISTS metadata;
CREATE TABLE metadata (
  id int(11) NOT NULL auto_increment,
  title varchar(255) NOT NULL default '',
  content varchar(255) default NULL,
  status varchar(255) default NULL,
  date datetime NOT NULL default '0000-00-00 00:00:00',
  signature varchar(255) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

#
# Dumping data for table `metadata`
#

INSERT INTO metadata VALUES (1, 'Calque de test', 'teeeeest', 'okay', '0000-00-00 00:00:00', 'mose');
INSERT INTO metadata VALUES (2, 'information', 'c\'est juste un point c\'est tout', 'okay', '0000-00-00 00:00:00', 'mose');
INSERT INTO metadata VALUES (3, 'Réseau Haut Débit', 'comment en faire partie?', '0', '2003-02-05 07:25:29', 'grenierasel@hotmail.com');
INSERT INTO metadata VALUES (4, 'Le Cervane', 'futur espace public numérique citoyen. La naissance d\'un lieu intermédiaire à St Martin.', '0', '2003-02-05 07:26:40', 'mathieu@lesateliersdusoleil');
INSERT INTO metadata VALUES (5, 'Le Bois St Martin', 'Premier établissement test pour le lancement de la charte "bed-and-cafe".\r\nC\'est aussi le "camp de base" des Ateliers du Soleil". Merci Monique:))', '1', '2003-02-05 07:29:34', 'mathieu@lesateliersdusoleil');
INSERT INTO metadata VALUES (6, 'en wacances à walli', '', '0', '2003-02-05 07:31:26', 'bibi@regina.com');
INSERT INTO metadata VALUES (7, 'Le Cervane', 'futur espace public numérique citoyen. La naissance d\'un lieu intermédiaire à St Martin.', '1', '2003-02-05 09:39:12', 'mathieu@lesateliersdusoleil');
INSERT INTO metadata VALUES (8, 'sous-repartiteur', '67545673723', '0', '2003-02-06 16:35:32', 'dsdsds');
INSERT INTO metadata VALUES (9, 'repartiteur principal', 'de Mainte-Marie', '0', '2003-02-06 18:00:53', 'jerome');
INSERT INTO metadata VALUES (10, 'repartiteur principal', 'de Sainte-Marie', '0', '2003-02-06 18:01:08', 'jerome');
INSERT INTO metadata VALUES (11, 'repartiteur principal', 'de la Flotte', '0', '2003-02-06 18:02:07', 'jerome');
INSERT INTO metadata VALUES (12, 'sous-repartiteur', '', '0', '2003-02-06 18:03:48', 'jerome');
INSERT INTO metadata VALUES (13, 'repartiteur principal', 'a Rivedoux', '0', '2003-02-06 18:06:38', 'Jerome');
INSERT INTO metadata VALUES (14, 'repartiteur', 'de Saint-Martin', '0', '2003-02-06 18:08:08', 'jerome');
INSERT INTO metadata VALUES (15, 'repartiteur pricipal', 'Le Bois Plage', '0', '2003-02-06 18:15:17', '');
INSERT INTO metadata VALUES (16, 'repartiteur principal', 'La Couarde Sur Mer', '0', '2003-02-06 18:20:39', '');
INSERT INTO metadata VALUES (17, 'repartiteur principal', 'Ars En Re', '0', '2003-02-06 18:23:10', '');
INSERT INTO metadata VALUES (18, 'repartiteur principal', 'Loix en Re', '0', '2003-02-06 18:25:54', '');
INSERT INTO metadata VALUES (19, 'ds', 'ds', '0', '2003-03-26 05:56:00', '');
# --------------------------------------------------------

#
# Table structure for table `objdots`
#

DROP TABLE IF EXISTS objdots;
CREATE TABLE objdots (
  dotid int(11) NOT NULL default '0',
  objectid int(11) NOT NULL default '0',
  ranknum int(11) NOT NULL auto_increment,
  PRIMARY KEY  (dotid,objectid,ranknum)
) TYPE=MyISAM COMMENT='Relation beetween Dots and Objects. Can mean it''s a line.';

#
# Dumping data for table `objdots`
#

INSERT INTO objdots VALUES (1, 1, 1);
INSERT INTO objdots VALUES (2, 2, 1);
INSERT INTO objdots VALUES (3, 3, 1);
INSERT INTO objdots VALUES (4, 4, 1);
INSERT INTO objdots VALUES (5, 5, 1);
INSERT INTO objdots VALUES (6, 6, 1);
INSERT INTO objdots VALUES (7, 7, 1);
INSERT INTO objdots VALUES (8, 9, 1);
INSERT INTO objdots VALUES (9, 10, 1);
INSERT INTO objdots VALUES (10, 11, 1);
INSERT INTO objdots VALUES (11, 12, 1);
INSERT INTO objdots VALUES (12, 13, 1);
INSERT INTO objdots VALUES (13, 14, 1);
INSERT INTO objdots VALUES (14, 15, 1);
INSERT INTO objdots VALUES (15, 16, 1);
INSERT INTO objdots VALUES (16, 17, 1);
INSERT INTO objdots VALUES (17, 18, 1);
INSERT INTO objdots VALUES (18, 19, 1);
# --------------------------------------------------------

#
# Table structure for table `object`
#

DROP TABLE IF EXISTS object;
CREATE TABLE object (
  id int(11) NOT NULL auto_increment,
  name varchar(255) default NULL,
  meta int(11) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

#
# Dumping data for table `object`
#

INSERT INTO object VALUES (1, 'premier point', 2);
INSERT INTO object VALUES (2, 'Réseau Haut Débit', 3);
INSERT INTO object VALUES (3, 'Le Cervane', 4);
INSERT INTO object VALUES (4, 'Le Bois St Martin', 5);
INSERT INTO object VALUES (5, 'en wacances à walli', 6);
INSERT INTO object VALUES (6, 'Le Cervane', 7);
INSERT INTO object VALUES (8, 'UU', 8);
INSERT INTO object VALUES (9, 'repartiteur principal', 9);
INSERT INTO object VALUES (10, 'repartiteur principal', 10);
INSERT INTO object VALUES (11, 'repartiteur principal', 11);
INSERT INTO object VALUES (12, 'sous-repartiteur', 12);
INSERT INTO object VALUES (13, 'repartiteur principal', 13);
INSERT INTO object VALUES (14, 'repartiteur', 14);
INSERT INTO object VALUES (15, 'repartiteur pricipal', 15);
INSERT INTO object VALUES (16, 'repartiteur principal', 16);
INSERT INTO object VALUES (17, 'repartiteur principal', 17);
INSERT INTO object VALUES (18, 'repartiteur principal', 18);
INSERT INTO object VALUES (19, 'ds', 19);

