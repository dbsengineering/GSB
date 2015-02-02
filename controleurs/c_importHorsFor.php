<?php

/**
 * Classe d'accès aux données. 

 * Utilise les services de la classe PDO
 * pour l'application GSB
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO 
 * $monPdoGsb qui contiendra l'unique instance de la classe

 * @package default
 * @author Cheri Bibi
 * @version    1.0
 * @link       http://www.php.net/manual/fr/book.pdo.php
 */


require_once('../include/class.pdogsb.inc.php');
require_once('../include/fct.inc.php');

if(isset($_POST['postId']) && isset($_POST['postMois'])){
    
    $idVisiteur = $_POST['postId'];
    $mois = $_POST['postMois'];
    
    $requete = PdoGsb::getPdoGsb();
    $verifiFicheMois = $requete->estPremierFraisMois($idVisiteur, $mois);
    
    //Si le visiteur à une fiche frais sur le mois passé en paramètre
    //Alors on récupère les données et les retourne.
    if($verifiFicheMois){
        $horsForfait = $requete->getLesFraisHorsForfait($idVisiteur, $mois);
        
        //Si les listes ne sont pas vides alors on merge les 2 listes
        //Et on les envoie.
        if($fraisAvalider && $etatFiche){
            
            echo json_encode($horsForfait);//Affiche/Envoi liste globale
        }
    }else{
        //On retourne l'erreur qui est 0
        echo json_last_error();
    }
}