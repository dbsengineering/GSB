<?php
/**
* c_reportSupp.php
*/

/** 
 * Controleur qui reporte et supprime les frais hors forfait 
 * Suivant le numéro qui est passé en paramètre.
 *
 * @package controleurs
 * @copyright 2014-2015 CAVRON Jérémy
 * @author Cavron Jérémy
 * @version v 1.0
 */
require_once('../include/class.pdogsb.inc.php');

if (isset($_POST['postNumFunc']) && isset($_POST['postId'])) {

    $numFunction = $_POST['postNumFunc'];
    $idHF = $_POST['postId'];


    switch ($numFunction) {
        case "0":
            report($idHF);
            break;
        case "1":
            supprimer($idHF);
            break;
    }
}

/**
 * Procédure de report du frais Hors forfait.
 * 
 * @package controleurs
 * @param int $idHF : est le numéro d'index d'un visiteur dans la liste de l'interface.
 */
function report($idHF) {
    $idVisit = $_POST['postIdVis'];
    if (isset($_POST['postIdVis'])) {

        //Récupèration du mois de la ligne de frais hors forfait en cours de traitement
        $mois = PdoGsb::getPdoGsb()->getMoisFicheHF($idHF);
        $numMois = substr($mois, 4, 2);
        $numAnnee = substr($mois, 0, 4);
        if ($numMois == 12) {
            $numMois = "1";
            $numAnnee = $numAnnee + 1;
        } else {
            $numMois = $numMois + 1;
        }
        $mois = "$numAnnee" . "0" . "$numMois";

        $premierMois = PdoGsb::getPdoGsb()->estPremierFraisMois($idVisit, $mois);

        //Si le visiteur possède une fiche de frais pour le mois alors on l'initialise en création
        if ($premierMois) {
            PdoGsb::getPdoGsb()->creeNouvellesLignesFrais($idVisit, $mois);
            PdoGsb::getPdoGsb()->majEtatFicheFrais($idVisit, $mois, 'CR');
        }
        PdoGsb::getPdoGsb()->majLigneFraisHF($idHF, $mois);
    }
}

/**
 * Procédure de suppression du frais Hors forfait.
 * 
 * @package controleurs
 * @param int $idHF : est le numéro d'index d'un visiteur dans la liste de l'interface.
 */
function supprimer($idHF) {
    PdoGsb::getPdoGsb()->supprimerFraisHorsForfait($idHF);
}
