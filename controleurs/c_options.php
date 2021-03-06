<?php
/**
* c_options.php
*/

/** 
 * Controleur pour les options.
 *
 * @copyright 2014-2015 CAVRON Jérémy
 * @package controleurs
 * @author Cavron Jérémy
 * @version v 1.0
 */


$idVisiteur = $_SESSION['idVisiteur'];//Id du visiteur
$login = $_SESSION['login'];//Login du visiteur
$action = $_REQUEST['action'];//Action à réaliser

$visiteur = $pdo->getInfosVisId($idVisiteur);

//Vérification si le visiteur est un comptable ou un administrateur.
//Si c'est un comptable, alors on affiche le sommaire comptable.
//Si c'est un adminitrateur, alors on affiche un sommaire administrateur.
//Sinon on affiche le sommaire normal des visiteurs.
if (!empty($visiteur['type']) && $visiteur['type'] === "comp") {
    include("./vues/v_sommaireComptable.php");
} else {
    include("./vues/v_sommaire.php");
}

switch ($action) {
    case 'changeMdp': {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            //Initialisation du mot de passe de la première et la deuxième case.
            $mdp = $_POST['mdp'];
            $mdpNew = $_POST['mdpNew'];
            
            //Si les mot de passe sont identiques alors on change le mot de passe
            if($mdp === $mdpNew){
                $mdp = sha1($login.$mdp);//Chiffrage du mot de passe
                $pdo->setMdpVisiteur($idVisiteur, $mdp);//Modification dans la bdd
                ajouterErreur("Votre nouveau mot de passe a été pris en compte.");
                include("./vues/v_message.php");
            }else{
                ajouterErreur("Ups..Le mot de passe que vous avez saisi n'est "
                        . "pas identique au deuxième. Recommencez !");
                include("./vues/v_erreurs.php");
            }
        } 
        break;
    }
}
include("vues/v_options.php");
