-- MySQL dump 8.22
--
-- Host: localhost    Database: localis_littoral
---------------------------------------------------------
-- Server version	3.23.55-log


CREATE TABLE dots (
  id int(11) NOT NULL auto_increment,
  E int(11) NOT NULL default '0',
  N int(11) NOT NULL default '0',
  Z int(11) NOT NULL default '0',
  PRIMARY KEY  (id)
) TYPE=MyISAM; 


CREATE TABLE layer (
  layerid int(11) NOT NULL auto_increment,
  layername varchar(255) default NULL,
  layertype enum('point','line') default 'point',
  layergroup varchar(255) default NULL,
  layercolor varchar(255) default NULL,
  layersize tinyint(4) default NULL,
  layersymbol varchar(255) default NULL,
  layermeta int(11) unsigned default NULL,
  PRIMARY KEY  (layerid)
) TYPE=MyISAM;

CREATE TABLE layerobj (
  objectid int(11) NOT NULL default '0',
  layerid int(11) NOT NULL default '0',
  ranknum int(11) NOT NULL default '0',
  PRIMARY KEY  (layerid,objectid,ranknum)
) TYPE=MyISAM;

CREATE TABLE metadata (
  id int(11) NOT NULL auto_increment,
  title varchar(255) NOT NULL default '',
  content varchar(255) default NULL,
  status varchar(255) default NULL,
  date datetime NOT NULL default '0000-00-00 00:00:00',
  signature varchar(255) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

CREATE TABLE objdots (
  dotid int(11) NOT NULL default '0',
  objectid int(11) NOT NULL default '0',
  ranknum int(11) NOT NULL auto_increment,
  PRIMARY KEY  (dotid,objectid,ranknum)
) TYPE=MyISAM; 

CREATE TABLE object (
  id int(11) NOT NULL auto_increment,
  name varchar(255) default NULL,
  meta int(11) default NULL,
  PRIMARY KEY  (id)
) TYPE=MyISAM;

