<?php

/**
 * c_enregistreDonn.php

 * Controleur qui enregistre, modifie, et rembourse les frais
 * Suivant le numéro qui est passé en paramètre, une procédure intervient

 * @author Cavron Jérémy
 */

require_once('../include/class.pdogsb.inc.php');
require_once('../include/fct.inc.php');

if(isset($_POST['postNumFunc'])){
    
    $numFunction = $_POST['postNumFunc'];
    
    switch ($numFunction){
        case 0:
            valider();
            break;
        case 1:
            rembourser();
            break;
    }
}

function rembourser() {
    if(isset($_POST['postId']) && isset($_POST['postMois'])){
        var_dump($_POST['postMois']);//test
    }
}

function valider(){
    if(isset($_POST['postId']) && isset($_POST['postMois'])){
        echo("validation");
    }
}
?>