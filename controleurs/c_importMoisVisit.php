<?php
/**
* c_importMoisVisit.php
*/

/** 
 * Controleur qui importe la liste des mois visiteur.
 *
 * @copyright 2014-2015 CAVRON Jérémy
 * @package controleurs
 * @author Cavron Jérémy
 * @version v 1.0
 */
//import de la classe pdo si elle n'a pas déjà été importée
require_once('../include/class.pdogsb.inc.php');

//Test si id visiteur a bien été reçu ou existe
if(isset($_POST['postId'])){

    $idVisit = $_POST['postId'];//Initialisation de la variable $idVisit avec l'id du visiteur reçu en paramètre

    //Initialisation de la variable $requete avec l'objet pdo
    $requete = PdoGsb::getPdoGsb();
    
    $listMoisVisit = $requete->getLesMoisDisponibles($idVisit);

    //Si on reçoit une liste alors on la retourne
    if(!empty($listMoisVisit)){
        
        echo json_encode($listMoisVisit);
    }
}
?>
