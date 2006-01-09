<?php
/* Fonctions acces LEI

Principe de fonctionnement: un script "cronable", nommé dumpxmlLEI2sql.php attaque le lei
Pour l'instant ce script ne peut pas etre exécuté sur e-toil.net, car il requiert un php compilé avec la bibliothèque simple_xml.

Ce script génère 2 fichiers:
- un fichier texte listant la nomenclature du LEI
modèle : (G=genre, C=catégorie, T=Type)
	G|30000001|Renseignements pratiques
	C|30000001|Services
	T|30000001|Stations services
	T|30000003|Banques (distributeurs)
	T|30000103|Locations de véhicules
rem: la table lei_categ ne sert plus
- un fichier SQl destiné à la mise à jour de la table lei_fiches
*/



class lei_acc {
	var $tbselcats=array() ;
	var $nomenc_fn="/usr/local/etoil/libs/nomenc_lei.txt";
	var $leaf_img="img/p_tux_L.gif";
	var $strTree; // le code 
	

function GenLeiCatTree(&$TreeObj) { // argument transmis par r?f?rence
//echDL3T1line ($id,$pid,$label,$cur_depth,$title="",$href="",$onclickJSAction="",$disp=true,$leafimg="",$dispfoldplus=false,$ckbcheked=false,$nodeopen,$cdckbox=true)

	$fd=fopen($this->nomenc_fn,"r") or die ("impossible d'ouvrir le fichier de nomenclature LEI $nomenc_fn");
	while (!feof ($fd)) {
  		$buffer = fgets($fd, 4096);
		$tbl=explode("|",$buffer);
		$tbl[2]=utf8_decode($tbl[2]);
		switch ($tbl[0]) {
			case "G":
			$CurGenre="G".$tbl[1];
			$this->strTree.=$TreeObj->echDL3T1line ($CurGenre,0,$tbl[2],1,"","","",true,"",true,false,$_REQUEST['n3o'.$CurGenre],false)."\n";
			break;

			case "C":
			$CurCateg=$CurGenre."C".$tbl[1];
			$this->strTree.=$TreeObj->echDL3T1line ($CurCateg,$CurGenre,$tbl[2],2,"","","",($_REQUEST['n3o'.$CurGenre]=="true" ? true : false),"",true,($_REQUEST['c3k'.$CurCateg]!="" ? true : false),$_REQUEST['n3o'.$CurCateg])."\n";
			break;

			case "T":
			$CurType=$CurCateg."T".$tbl[1];
			//if ($_REQUEST['c3k'.$CurType]!="") echo 'c3k'.$CurType."=".$_REQUEST['c3k'.$CurType]."|";
			$this->strTree.=$TreeObj->echDL3T1line ($CurType,$CurCateg,$tbl[2],3,"","","",($_REQUEST['n3o'.$CurCateg]=="true" ? true : false),$this->leaf_img,false,($_REQUEST['c3k'.$CurType]!="" ? true : false))."\n";
			break;
			}
	}
	fclose ($fd);
		
	}
} // fin def objet LEI

?>
