<?php
/**
* c_importVisit.php
*/

/** 
 * Controleur qui importe la liste des visiteur.
 *
 * @copyright 2014-2015 CAVRON Jérémy
 * @package controleurs
 * @author Cavron Jérémy
 * @version v 1.0
 */
require_once('../include/class.pdogsb.inc.php');

$requete = PdoGsb::getPdoGsb();
$infosVisiteurs = $requete->getVisiteur();
if($infosVisiteurs){
    echo json_encode($infosVisiteurs);
}

?>