<?php
/**
* c_gererFrais.php
*/

/** 
 * Controleur de gestion des frais pour l'application GSB.
 *
 * @copyright 2014-2015 CAVRON Jérémy
 * @package controleurs
 * @author Cavron Jérémy
 * @version v 1.0
 */
include("vues/v_sommaire.php");
$idVisiteur = $_SESSION['idVisiteur'];
$mois = getMois(date("d/m/Y"));
$numAnnee = substr($mois, 0, 4);
$numMois = substr($mois, 4, 2);
$action = $_REQUEST['action'];

switch ($action) {
    case 'saisirFrais': {
            if ($pdo->estPremierFraisMois($idVisiteur, $mois)) {
                $pdo->creeNouvellesLignesFrais($idVisiteur, $mois);
            }
            break;
        }
    case 'validerMajFraisForfait': {
            if (isset($_REQUEST['lesFrais'])) {
                $lesFrais = $_REQUEST['lesFrais'];
                if (lesQteFraisValides($lesFrais)) {
                    $pdo->majFraisForfait($idVisiteur, $mois, $lesFrais);
                } else {
                    ajouterErreur("Les valeurs des frais doivent être numériques");
                    include("vues/v_erreurs.php");
                }
            }
            break;
        }
    case 'validerCreationFrais': {
            $dateFrais = $_REQUEST['dateFrais'];
            $libelle = $_REQUEST['libelle'];
            $montant = $_REQUEST['montant'];
            valideInfosFrais($dateFrais, $libelle, $montant);
            if (nbErreurs() != 0) {
                include("vues/v_erreurs.php");
            } else {
                $pdo->creeNouveauFraisHorsForfait($idVisiteur, $mois,
                        $libelle, $dateFrais, $montant);
            }
            break;
        }
    case 'supprimerFrais': {
            $idFrais = $_REQUEST['idFrais'];
            $pdo->supprimerFraisHorsForfait($idFrais);
            break;
        }
}

$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $mois);

$lesFraisForfait = array_merge($pdo->getLesFraisForfait($idVisiteur, $mois),
        $pdo->getTarifForfait());

include("vues/v_listeFraisForfait.php");
include("vues/v_listeFraisHorsForfait.php");
?>