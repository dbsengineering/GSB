<?php
/**
 * c_importFraisValid.php

 * Controleur qui récupère les frais du mois envoyé en paramètre
 * d'un commerciale également eenvoyé en paramètre.

 * @author Cavron Jérémy
 */


require_once('../include/class.pdogsb.inc.php');
require_once('../include/fct.inc.php');

//Si les données sont reçus et conforme, alors on envoie la requête
//et on récupère le résultat pour le retourner.
if(isset($_POST['postId']) && isset($_POST['postMois'])){
    
    $idVisiteur = $_POST['postId'];
    $mois = $_POST['postMois'];
    //$idVisiteur = 'gg31'; //pour le test
    //$mois = '201501';//pour le test
    
    $requete = PdoGsb::getPdoGsb();
    $verifiFicheMois = $requete->estPremierFraisMois($idVisiteur, $mois);
    
    //Si le visiteur à une fiche frais sur le mois passé en paramètre
    //Alors on récupère les données et les retourne.
    if($verifiFicheMois){
        $fraisAvalider = $requete->getLesFraisForfait($idVisiteur, $mois);
        $etatFiche = $requete->getLesInfosFicheFrais($idVisiteur, $mois);
        $horsForfait = $requete->getLesFraisHorsForfait($idVisiteur, $mois);
        
        //Si les listes ne sont pas vides alors on merge les 3 listes
        //Et on les envoie.
        if($fraisAvalider && $etatFiche){
            

            //Concaténation des 3 listes
            $listeFrais = array_merge_recursive($fraisAvalider, $etatFiche, $horsForfait);
            
            echo json_encode($listeFrais,JSON_UNESCAPED_UNICODE);//Affiche/Envoi liste globale
        }
    }else{
        //On retourne l'erreur qui est 0
        echo json_last_error();
    }
}
?>