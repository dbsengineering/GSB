<?php
require_once('../include/class.pdogsb.inc.php');

$requete = PdoGsb::getPdoGsb();
$infosVisiteurs = $requete->getVisiteur();
if($infosVisiteurs){
    echo json_encode($infosVisiteurs);
}

?>