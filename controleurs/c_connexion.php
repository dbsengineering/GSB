<?php
if(!isset($_REQUEST['action'])){
	$_REQUEST['action'] = 'demandeConnexion';
}
$action = $_REQUEST['action'];
switch($action){
	case 'demandeConnexion':{
		include("./vues/v_connexion.php");
		break;
	}
	case 'valideConnexion':{
                if($_SERVER["REQUEST_METHOD"] == "POST"){
                    $login = $_POST['login'];
                    $mdp = $_POST['mdp'];
                }
		//$login = $_REQUEST['login'];
		//$mdp = $_REQUEST['mdp'];
		$visiteur = $pdo->getInfosVisiteur($login,$mdp);
		if(!is_array( $visiteur)){
			ajouterErreur("Login ou mot de passe incorrect");
			include("./vues/v_erreurs.php");
			include("./vues/v_connexion.php");
		}
		else{
			$id = $visiteur['id'];
			$nom =  $visiteur['nom'];
			$prenom = $visiteur['prenom'];
			connecter($id,$nom,$prenom);

                        //Vérification si le visiteur est un comptable ou un administrateur.
                        //Si c'est un comptable, alors on affiche le sommaire comptable.
                        //Si c'est un adminitrateur, alors on affiche un sommaire administrateur.
                        //Sinon on affiche le sommaire normal.
                        if(!empty($visiteur['type']) && $visiteur['type'] === "comp"){
                            include("./vues/v_sommaireComptable.php");
                        }else{
                            include("./vues/v_sommaire.php");
                        }
		}
		break;
	}
	default :{
		include("./vues/v_connexion.php");
		break;
	}
}
