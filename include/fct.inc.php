<?php
/**
* fct.inc.php
*/

/** 
 * Fonctions pour l'application GSB
 *
 * @copyright 2014-2015 CAVRON Jérémy
 * @package Include
 * @author Cavron Jérémy
 * @version v 1.0
 */

 /**
 * Fonction qui teste si un quelconque visiteur est connecté.
 * 
 * @package include 
 * @return bool isset($_SESSION['idVisiteur']) : vrai ou faux.
 */
function estConnecte(){
  return isset($_SESSION['idVisiteur']);
}
/**
 * Procédure qui enregistre dans une variable session les infos d'un visiteur.
 *
 * @package include 
 * @param string $id : est l'id du visiteur. 
 * @param string $nom : est le nom du visiteur.
 * @param string $prenom : est le prénom du visiteur.
 */
function connecter($id,$nom,$prenom){
	$_SESSION['idVisiteur']= $id; 
	$_SESSION['nom']= $nom;
	$_SESSION['prenom']= $prenom;
}
/**
 * Procédure qui détruit la session active.
 * 
 * @package include 
 */
function deconnecter(){
	session_destroy();
}
/**
 * Fonction qui transforme une date au format français jj/mm/aaaa 
 * et retourne le format anglais aaaa-mm-jj
 *
 * @package include 
 * @param string $maDate : est la date au format  jj/mm/aaaa.
 * @return string : la date au format anglais aaaa-mm-jj.
*/
function dateFrancaisVersAnglais($maDate){
	@list($jour,$mois,$annee) = explode('/',$maDate);
	return date('Y-m-d',mktime(0,0,0,$mois,$jour,$annee));
}
/**
 * Fonction qui transforme une date au format format anglais aaaa-mm-jj
 * et retourne le format français jj/mm/aaaa 
 *
 * @package include 
 * @param string $maDate : est la date au format  aaaa-mm-jj.
 * @return string : est la date au format format français jj/mm/aaaa.
*/
function dateAnglaisVersFrancais($maDate){
   @list($annee,$mois,$jour)=explode('-',$maDate);
   $date="$jour"."/".$mois."/".$annee;
   return $date;
}
/**
 * Fonction qui retourne le mois au format aaaamm selon le jour dans le mois.
 *
 * @package include 
 * @param string $date : est la date au format  jj/mm/aaaa.
 * @return string $annee.$mois : est le mois au format aaaamm
*/
function getMois($date){
		@list($jour,$mois,$annee) = explode('/',$date);
		if(strlen($mois) == 1){
			$mois = "0".$mois;
		}
		return $annee.$mois;
}

/* Gestion des erreurs*/
/**
 * Fonction qui indique si une valeur est un entier positif ou nul
 * et retourne vrai ou faux.
 *
 * @package include 
 * @param $valeur
 * @return bool : est un booléen vrai ou faux
*/
function estEntierPositif($valeur) {
	return preg_match("/[^0-9]/", $valeur) == 0;
	
}

/**
 * Indique si un tableau de valeurs est constitué d'entiers positifs ou nuls
 *
 * @package include 
 * @param array $tabEntiers : est le tableau.
 * @return bool $ok : est un booléen vrai ou faux.
*/
function estTableauEntiers($tabEntiers) {
	$ok = true;
	foreach($tabEntiers as $unEntier){
		if(!estEntierPositif($unEntier)){
		 	$ok=false; 
		}
	}
	return $ok;
}
/**
 * Fonction qui vérifie si une date est inférieure d'un an à la date actuelle
 * et retourne vrai ou faux.
 *
 * @package include 
 * @param string $dateTestee : est une date. 
 * @return bool ($anneeTeste.$moisTeste.$jourTeste < $AnPasse) : retourne un booléen vrai ou faux.
*/
function estDateDepassee($dateTestee){
	$dateActuelle=date("d/m/Y");
	@list($jour,$mois,$annee) = explode('/',$dateActuelle);
	$annee--;
	$AnPasse = $annee.$mois.$jour;
	@list($jourTeste,$moisTeste,$anneeTeste) = explode('/',$dateTestee);
	return ($anneeTeste.$moisTeste.$jourTeste < $AnPasse); 
}
/**
 * Fonction qui vérifie la validité du format d'une date française jj/mm/aaaa
 * et retourne vrai ou faux. 
 *
 * @package include
 * @param string $date : est la date. 
 * @return bool $dateOK : est un booléen vrai ou faux
*/
function estDateValide($date){
	$tabDate = explode('/',$date);
	$dateOK = true;
	if (count($tabDate) != 3) {
	    $dateOK = false;
    }
    else {
		if (!estTableauEntiers($tabDate)) {
			$dateOK = false;
		}
		else {
			if (!checkdate($tabDate[1], $tabDate[0], $tabDate[2])) {
				$dateOK = false;
			}
		}
    }
	return $dateOK;
}

/**
 * Vérifie que le tableau de frais ne contient que des valeurs numériques 
 *
 * @package include
 * @param array $lesFrais : est un tableau de frais.
 * @return bool : est un booléen vrai ou faux
*/
function lesQteFraisValides($lesFrais){
	return estTableauEntiers($lesFrais);
}
/**
 * Procédure qui vérifie la validité des trois arguments : la date, 
 * le libellé du frais et le montant.
 * Des message d'erreurs sont ajoutés au tableau des erreurs
 *
 * @package include
 * @param string $dateFrais : est la date du frais.
 * @param string $libelle : est le libellé du frais.
 * @param real $montant : est le montant du frais.
 */
function valideInfosFrais($dateFrais,$libelle,$montant){
	if($dateFrais==""){
		ajouterErreur("Le champ date ne doit pas être vide");
	}
	else{
		if(!estDatevalide($dateFrais)){
			ajouterErreur("Date invalide");
		}	
		else{
			if(estDateDepassee($dateFrais)){
				ajouterErreur("date d'enregistrement du frais dépassé, plus de 1 an");
			}			
		}
	}
	if($libelle == ""){
		ajouterErreur("Le champ description ne peut pas être vide");
	}
	if($montant == ""){
		ajouterErreur("Le champ montant ne peut pas être vide");
	}
	else
		if( !is_numeric($montant) ){
			ajouterErreur("Le champ montant doit être numérique");
		}
}
/**
 * Procédure qui ajoute le libellé d'une erreur au tableau des erreurs.
 *
 * @package include
 * @param string $msg : est le libellé de l'erreur.
 */
function ajouterErreur($msg){
   if (! isset($_REQUEST['erreurs'])){
      $_REQUEST['erreurs']=array();
	} 
   $_REQUEST['erreurs'][]=$msg;
}
/**
 * Fonction qui retoune le nombre de lignes du tableau des erreurs.
 *
 * @package include
 * @return int count($_REQUEST['erreurs']) : est le nombre d'erreurs.
 */
function nbErreurs(){
   if (!isset($_REQUEST['erreurs'])){
	   return 0;
	}
	else{
	   return count($_REQUEST['erreurs']);
	}
}
?>