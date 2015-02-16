<?php
/**
* c_enregistreDonn.php
*/

/** 
 * Controleur qui enregistre, modifie, et rembourse les frais
 * Suivant le numéro qui est passé en paramètre, une procédure intervient.
 * En plus, une fonction qui retourne les tarifs.
 * 
 * PHP version 5.5.12
 *
 * @category    Controleurs
 * @package     Controleurs
 * @author      Cavron Jérémy
 * @copyright   2014-2015 CAVRON Jérémy
 * @version     v 1.0
 */
require_once('../include/class.pdogsb.inc.php');

if(isset($_POST['postNumFunc'])){
    
    $numFunction = $_POST['postNumFunc'];
    
    switch ($numFunction){
        case "0":
            valider();
            break;
        case "1":
            rembourser();
            break;
        case "2":
            modifier();
            break;
    }
}

/**
 * Procédure de validation.
 * 
 * @package controleurs
 */
function valider(){
    
    if(isset($_POST['postId']) && isset($_POST['postJustif']) && 
            isset($_POST['postMois'])){
        
        $idVis = $_POST['postId'];
        $nbJustif = $_POST['postJustif'];
        $annMois = $_POST['postMois'];

        
        PdoGsb::getPdoGsb()->majNbJustificatifs($idVis, $annMois, $nbJustif);
        //Mise à jour de l'état, du montant de la fiche de frais
        PdoGsb::getPdoGsb()->majEtatFicheFraisJustMont($idVis, $annMois, 'VA');
        $montant = PdoGsb::getPdoGsb()->getLesInfosFicheFrais($idVis, $annMois);
        
        echo ($montant[3]);
    }
}

/**
 * Procédure de remboursement.
 * 
 * @package controleurs
 */
function rembourser() {

    if(isset($_POST['postId']) && isset($_POST['postMois'])){
        
        $idVis = $_POST['postId'];
        $annMois = $_POST['postMois'];
        
        PdoGsb::getPdoGsb()->majEtatFicheFrais($idVis, $annMois, 'RB');
    }
}
/**
 * Procédure de modification frais Forfait et le nombre de justificatifs.
 * 
 * @package controleurs
 */
function modifier(){
    
    if(isset($_POST['postId']) && isset($_POST['postMois']) && 
            isset($_POST['postTabFrais']) && isset($_POST['postJustif'])){

    
        $listeRecup = json_decode($_POST['postTabFrais']);
        $rep = $listeRecup[0];
        $nuit = $listeRecup[1];
        $km = $listeRecup[3];
        $etp = $listeRecup[2];
    
        $idVis = $_POST['postId'];
        $nbJustif = $_POST['postJustif'];
        $annMois = $_POST['postMois'];
        $listeFrais = array('REP' => $rep,'NUI' => $nuit,'KM' => $km,'ETP' => $etp);
        
        //Mise à jour du nombre de justificatifs
        PdoGsb::getPdoGsb()->majNbJustificatifs($idVis, $annMois, $nbJustif);

        //On envoie seulement les frais Forfait
        //Mise à jour des forfait
        PdoGsb::getPdoGsb()->majFraisForfait($idVis, $annMois, $listeFrais);
    }
}
?>