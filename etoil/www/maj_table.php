<?php 
$title = "Cartographie";
$db = true;
// simulation register_globals=On
foreach( $_REQUEST as $a => $b)
{
if ($a!="PHPSESSID")
	{
//	global $a;
	$$a = $b;
	}
}

include("setup.php");
// réponse a un ajout, modif ou suppression d'un enregistrement
$debug=false;
if ($debug) echovar("_FILES");

// s'il existe au moins 1 champ fichier-photo,
// on calcule la CLE POUR LE NOM DE STOCKAGE DES FICHIERS ATTACHES EVENTUELS
// uniquement en cas autre que modif: ds ce cas c'est pas la peine, $keycopy=$key
if ($modif=="1" && $keyf!="") {
	$keycopy=$keyf;
} else {
	$rpfl=msq("SELECT TYPEAFF from $TBDname where NM_TABLE='".$_REQUEST['NM_TABLE']."' AND TYPEAFF='FICFOT'");
	if (db_num_rows($rpfl)>0) { 
	//echovar("_FILES");
	// détermination champ cle pour stockage fichier ou image
	// on prend oid + 1; si c'est pas le bon, pas très grave
	if ($_SESSION[db_type]=="pgsql") {
		$rp1=msq("SELECT oid from ".$_REQUEST['NM_TABLE']." order by oid DESC LIMIT 1");
			$rp2=db_fetch_row($rp1);
			$keycopy=$rp2[0]+1;
			$keycopy=$keycopy."_";
		}
	else {
		// on recupere les noms des 2 1er champs (idem aux variables)
		$rqkc=msq("SELECT NM_CHAMP from $TBDname where NM_TABLE='".$_REQUEST['NM_TABLE']."' AND NM_CHAMP!='$NmChDT' ORDER BY ORDAFF, LIBELLE LIMIT 2");
		$nmchp=db_fetch_row($rqkc); 
		$chp=$nmchp[0];
		$mff=mysqff ($chp,$_REQUEST['NM_TABLE']);
		// dans mff on a les caract. de cle primaire, auto_increment, etc ... du 1er champ
		if (stristr($mff,"primary_key")) { // si 1er champ est une clé primaire
			// on regarde si c'est un auto incrément
			if (stristr($mff,"auto_increment") && (($modif==0) || ($modif==2))) 
				{ // si auto increment et nouvel enregistrement ou copie
				$rp1=msq("SELECT $chp from ".$_REQUEST['NM_TABLE']." order by $chp DESC LIMIT 1");
				$rp2=mysql_fetch_row($rp1);
				$keycopy=$rp2[0]+1;
				$keycopy=$keycopy."_";
				}
			else 
				{ // si pas auto increment ou modif, on recup la valeur
				$keycopy=$$nmchp[0]."_"; // VALEUR du premier champ  
				}
			
			}
		else // si 1er champ pas cle primaire, elle est forcement constituee des 2 autres
			{ 
			$keycopy=$$nmchp[0]; // VALEUR du premier champ
			$nmchp=mysql_fetch_row($rqkc);
			$keycopy=$keycopy."_".$$nmchp[0]."_";// VALEUR du deuxieme champ
			}
		} // fin si pas session pgsql
	// echo "Keycopy: $keycopy <BR>";
	} // fin s'il y a au moins un champ fichier attaché
} // fin si autre que modif
  
// construction du set, necessite uniquement le nom du champ ..
$rq1=msq("SELECT NM_CHAMP from $TBDname where NM_TABLE='parcours' AND NM_CHAMP!='$NmChDT' AND (TYPEAFF!='HID' OR ( TT_PDTMAJ!='' AND TT_PDTMAJ!= NULL)) ORDER BY ORDAFF, LIBELLE");


$PYAoMAJ=new PYAobj();

$PYAoMAJ->NmBase=$dbname;
$PYAoMAJ->NmTable=$_REQUEST['NM_TABLE'];
$PYAoMAJ->TypEdit=$modif;

// traitement spéciaux de MAJ des valeurs calculées par le SIG
// fichier image du graphe
if ($_REQUEST['parcours_deniv_fname']!="" && $_REQUEST['parcours_deniv_cgraph']!="") {
	$_FILES['parcours_imgdeniv'][name]= $_REQUEST['parcours_deniv_fname'];
	$_FILES['parcours_imgdeniv'][error]="0"; //pas d'erreur
	$_FILES['parcours_imgdeniv'][tmp_name]=$_REQUEST['parcours_deniv_cgraph'];
}
// valeurs diverses
if ($_REQUEST['parcours_length_cvalue']>0) $_REQUEST['parcours_length']=$_REQUEST['parcours_length_cvalue'];
if ($_REQUEST['parcours_deniv_cvalue']>0) $_REQUEST['parcours_deniv']=$_REQUEST['parcours_deniv_cvalue'];
if ($_REQUEST['parcours_time_cvalue']>0) $_REQUEST['parcours_time']=$_REQUEST['parcours_time_cvalue'];

$tbset=array();
while ($res1=db_fetch_row($rq1))
  {
  $NOMC=$res1[0]; // nom variable=nom du champ
  $PYAoMAJ->NmChamp=$NOMC;
  $PYAoMAJ->InitPO();
  $PYAoMAJ->ValChp=$_REQUEST[$NOMC]; // issu du formulaire
  if ($PYAoMAJ->TypeAff=="FICFOT") {
     if ($_FILES[$NOMC][name]!="" && $_FILES[$NOMC][error]!="0") die ("error: impossible de joindre le fichier ".$_FILES[$NOMC][name]."; sa taille est peut-etre trop importante");
     $VarFok="Fok".$NOMC;
     $PYAoMAJ->ValChp=($_FILES[$NOMC][tmp_name]!="" ? $_FILES[$NOMC][tmp_name] : $PYAoMAJ->ValChp);
     $PYAoMAJ->Fok=$$VarFok;
     $VarFname=$NOMC."_name"; // ancienne méthode
     $PYAoMAJ->Fname=($$VarFname !="" ? $$VarFname : $_FILES[$NOMC][name]);
     $VarFsize=$NOMC."_size";// ancienne méthode
     $PYAoMAJ->Fsize=($$VarFsize!="" ? $$VarFsize : $_FILES[$NOMC][size]);
     $VarOldFName="Old".$NOMC;
     $PYAoMAJ->OFN=$$VarOldFName;
     if ($modif==-1) { // suppression de l'enregistrement
        $rqncs=msq("select ".$PYAoMAJ->NmChamp." from ".$PYAoMAJ->NmTable." where $key ");
        $rwncs=db_fetch_row($rqncs);
        $PYAoMAJ->Fname=$rwncs[0];
        }
     }
  $tbset=array_merge($tbset,$PYAoMAJ->RetSet($keycopy,true)); // key copy sert à la gestion des fichiers liés
  // la gestion des fichiers est faite aussi là-dedans

  } // fin boucle sur les champs

//echovar("tbset");

$key=stripslashes($key);
if ($debug) echo "Clé: $key <BR>";

// GROS BUG  $where=" where ".$key.($where_sup=="" ? "" : " and $where_sup");
$where=" where ".$key;
if ($modif==1) // Si on vient d'une édit"SELECT NM_CHAMP from $TBDname where NM_TABLE='parcours' AND NM_CHAMP!='$NmChDT' AND (TYPEAFF!='HID' OR( TT_PDTMAJ!='' AND TT_PDTMAJ!= NULL)) ORDER BY ORDAFF, LIBELLE"ion
  {
  $strqaj="UPDATE ".$_REQUEST['NM_TABLE']." SET ".tbset2set($tbset)." $where";
  }
else if ($modif==-1) // // Si on vient d'une suppression
  {
  $strqaj="DELETE FROM ".$_REQUEST['NM_TABLE']." $where";

  }
else // Si on vient de nv enregistrement
  {
  // Ajout dans la table Mysql
  $strqaj="INSERT INTO ".$_REQUEST['NM_TABLE']." ".tbset2insert($tbset);
  }
if ($debug) echo "requete sql: $strqaj";
msq($strqaj);
header ("location:".$_REQUEST['adrr_majt']); // 
?>
