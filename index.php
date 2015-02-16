<?php
/**
* index.php
*/

/** 
 * La page index est le fichier d'entré dans le site.
 *
 * @copyright 2014-2015 CAVRON Jérémy
 * @package default
 * @author Cavron Jérémy
 * @version v 1.0
 */
session_start();
require_once("include/fct.inc.php");
require_once("include/class.pdogsb.inc.php");
include("vues/v_entete.php") ;

$pdo = PdoGsb::getPdoGsb();
$estConnecte = estConnecte();


if(!isset($_REQUEST['uc']) || !$estConnecte){
     $_REQUEST['uc'] = 'connexion';
}	 
$uc = $_REQUEST['uc'];
switch($uc){
	case 'connexion':{
		include("controleurs/c_connexion.php");break;
	}
        case 'validationFrais':{
                include("controleurs/c_validationFrais.php");break;
        }
	case 'gererFrais' :{

		include("controleurs/c_gererFrais.php");break;
	}
	case 'etatFrais' :{
		include("controleurs/c_etatFrais.php");break; 
	}
        case 'options' :{
            include("controleurs/c_options.php");break;
        }
}
include("vues/v_pied.php") ;
?>