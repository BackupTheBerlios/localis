#!/bin/bash
if [ -z "$1" ]
 then
  echo "Vous devez entrer le nom du fichier, sans l extension"
  exit
 fi

# generation fichier sql
/usr/local/pgsql/bin/shp2pgsql -d $1.shp zimptmp_ctcg19 > $1.sql
# insertion dans la base
psql etoil < $1.sql

echo "le fichier $1 a ete insere dans la base etoil dans la table zimptmp_ctcg19"
exit
