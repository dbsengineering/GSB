<?php 
/**
* c_receptionDonnAndroid.php
*/

/** 
 * Contrôleur qui reçoit les données de l'application Android.
 * et envoie les frais du dernier mois vers la base de données.
 *
 * @copyright 2014-2015 CAVRON Jérémy
 * @package controleurs
 * @author Cavron Jérémy
 * @version v 1.0
 */
require_once('../include/class.pdogsb.inc.php');
require_once('../include/fct.inc.php');

$json = file_get_contents('php://input');
$obj = json_decode($json);
/*Si on reçoit bien un login et un mot de passe alors on se connecte
à la base de données et on importe les données.*/
if( $obj->{'login'} != "" && $obj->{'mdp'} != "") {
    $pdo = PdoGsb::getPdoGsb();
    
    
    //Initialisation des propriétés
    $loginAndro = $obj->{'login'};//Le login du visiteur
    $mdpAndro = $obj->{'mdp'};//Le mot de passe hashé du visiteur
    $visiteur = $pdo->getInfosVisiteur($loginAndro, $mdpAndro);//Le visiteur
    $idVisiteur = $visiteur['id'];//Id du visiteur
    $mois = $obj->{'dateKm'};//Récupération de la date d'un frais pour renseigner la date générale.
    $message = "Envoi effectué avec succès";
    
    $mois = getMois($mois);//Converti la date française (jj/MM/aaaa) en mois de lapplication. (aaaaMM)
    
    //Si le visiteur ne possède pas de fiche de frais alors on la crée
    if($pdo->estPremierFraisMois($idVisiteur, $mois)) {
        creeNouvellesLignesFrais($idVisiteur, $mois);
    }
    
    //--- frais forfait ---
    //Création d'un tableau de frais forfait avec les valeurs reçues
    $lesFrais = array("ETP" => $obj->{'qteEtape'}, "KM" => $obj->{'qteKm'}, 
            "NUI" => $obj->{'qteNuit'}, "REP" => $obj->{'qteRepas'});
            
    //$lesFraisH = $obj->{'listeFHf'}[0]->{'comFraisHf'};
    $lesFraisH = $obj->{'listeFHf'};
    
    //Récupération du nombre de lignes dans la liste des frais hors forfait
    $compte = count($lesFraisH);
    
    /*Suppression de tous les frais hors forfait en cas de mise à jour via
    l'application mobile.*/
    $pdo->supprimeToutFraisHf($idVisiteur, $mois);
    
    //Si la liste contient des données alors on traite
    if($compte != 0){
        
    
        /*Boucle sur toutes les lignes de la liste des frais hors forfait
        et enregistrement des frais hors forfait.*/
        for($i = 0; $i<= $compte -1; $i++){
        
            $libelle = $lesFraisH = $obj->{'listeFHf'}[$i]->{'comFraisHf'};
            $dateFrais = $lesFraisH = $obj->{'listeFHf'}[$i]->{'dateFraisHf'};
            $montant = $lesFraisH = $obj->{'listeFHf'}[$i]->{'montFraisHf'};
            
            //Création des frais hors forfait dans la base de données
            $pdo->creeNouveauFraisHorsForfait($idVisiteur, $mois,
                        $libelle, $dateFrais, $montant);
        }
    }
        
    //On vérifie si les quantité ont une valeur numérique
    if (lesQteFraisValides($lesFrais)) {
        
        //Mise à jour des frais forfait du mois en cours pour le visiteur
        $pdo->majFraisForfait($idVisiteur, $mois, $lesFrais);
        
    }else{
        $messsage = "Problème sur les quantités frais";
    }
  
    
    echo json_encode($message, JSON_UNESCAPED_UNICODE);
    
}else {
    $message = "Problème de login ou mot de passe.";
    echo json_encode($message, JSON_UNESCAPED_UNICODE);
}
?>

