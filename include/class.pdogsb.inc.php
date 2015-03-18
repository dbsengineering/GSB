<?php
/**
* class.pdogsb.inc.php
*/

/**
 * Classe d'accès aux données. 
 *
 * Utilise les services de la classe PDO
 * pour l'application GSB
 * Les attributs sont tous statiques,
 * les 4 premiers pour la connexion
 * $monPdo de type PDO 
 * $monPdoGsb qui contiendra l'unique instance de la classe
 *
 * PHP version 5.5.12
 *
 * @category    Include
 * @package     Include
 * @author      Cavron Jérémy
 * @copyright   2014-2015 CAVRON Jérémy
 * @link        http://www.php.net/manual/fr/book.pdo.php
 * @version     v 1.0
 */
class PdoGsb {
    
    /**
     * @var string $serveur : est le chemin du serveur.
     */
    private static $serveur = 'mysql:host=localhost';
    /**
     * @var string $bdd : est le nom de la base de données.
     */
    private static $bdd = 'dbname=baseDeDonnees';
    /**
     * @var string $user : est le login général pour accéder à la base de données.
     */
    private static $user = 'nomBDD';
    /**
     * @var string $mdp : est le mot de passe général pour accéder à la base de données.
     */
    private static $mdp = 'MotDePasseBdd';
    /**
     * @var object $monPdo : est le curseur pdo.
     */
    private static $monPdo;
    /**
     * @var object $monPdoGsb : est la classe initialisée à null.
     */
    private static $monPdoGsb = null;

    /**
     * Constructeur privé, crée l'instance de PDO qui sera sollicitée
     * pour toutes les méthodes de la classe.
     */
    private function __construct() {
        PdoGsb::$monPdo = new PDO(PdoGsb::$serveur . ';' . PdoGsb::$bdd, PdoGsb::$user, PdoGsb::$mdp);
        PdoGsb::$monPdo->query("SET CHARACTER SET utf8");
    }
    /**
     * Destructeur de la classe PdoGsb.
     */
    public function _destruct() {
        PdoGsb::$monPdo = null;
    }

    /**
     * Fonction statique qui crée l'unique instance de la classe.
     * Appel : $instancePdoGsb = PdoGsb::getPdoGsb();
     *
     * @return PdoGsb::$monPdoGsb : est l'unique objet de la classe PdoGsb
     */
    public static function getPdoGsb() {
        if (PdoGsb::$monPdoGsb == null) {
            PdoGsb::$monPdoGsb = new PdoGsb();
        }
        return PdoGsb::$monPdoGsb;
    }

    /**
     * Fonction qui retourne les informations d'un visiteur.
     * 
     * @param string $login : est le login utilisateur.
     * @param string $mdp : est le mot de passe de l'utilisateur.
     * @return array $ligne : est l'id, le nom et le prénom sous la forme d'un tableau associatif.
     */
    public function getInfosVisiteur($login, $mdp) {
        
        $rs = PdoGsb::$monPdo->prepare("call getInfosVisiteur (:login,:mdp)");
        $rs->bindValue(':login', $login, PDO::PARAM_STR);
        $rs->bindValue(':mdp', $mdp, PDO::PARAM_STR);

        $rs->execute();

        $ligne = $rs->fetch();

        return $ligne;
    }
    
    /**
     * Fonction qui retourne les informations d'un visiteur avec son id.
     * 
     * @param string $id : est l'id du visiteur.
     * @return array $ligne : est l'id, le nom et le prénom sous la forme d'un tableau associatif.
     */
    public function getInfosVisId($id) {
 
        $req = "SELECT * "
                ."FROM visiteur "
                ."WHERE id = '".$id."'";
        $rs = PdoGsb::$monPdo->query($req);
        
        $rs->execute();
        $ligne = $rs->fetch();

        return $ligne;
    }
    
    /**
     * Procédure qui modifie le mot de passe du visiteur.
     * 
     * @param string $idVisiteur : est l'id du visiteur.
     * @param string $nouvMdp : est le nouveau mot de passe.
     */
    public function setMdpVisiteur($idVisiteur, $nouvMdp) {
         $req = "UPDATE visiteur SET visiteur.mdp = '$nouvMdp' "
                 ."WHERE visiteur.id = '$idVisiteur'";
            PdoGsb::$monPdo->exec($req);
    }

    /**
     * Fonction qui récupère tous les id, nom et prénom des visiteurs (commerciaux)
     * et les retourne.
     * 
     * @return array $tousVis : est la liste des visiteur commerciaux.
     */
    public function getVisiteur() {
        $req = "SELECT id, nom, prenom, avatar "
                ."FROM visiteur "
                ."WHERE type is null "
                ."ORDER BY nom ASC";
        $rs = PdoGsb::$monPdo->query($req);
        $rs->execute();
        $tousVis = $rs->fetchAll();

        return $tousVis;
    }

    /**
     * Fonction qui retourne sous forme d'un tableau associatif toutes 
     * les lignes de frais hors forfait concernées par les deux arguments.
     *
     * La boucle foreach ne peut être utilisée ici car on procède
     * à une modification de la structure itérée - transformation du champ date.
     *
     * @param string $idVisiteur : est l'id du visiteur.
     * @param string $mois : est le mois sous la forme aaaamm.
     * @return array $lesLignes : tous les champs des lignes de frais hors forfait sous la forme d'un tableau associatif .
     */
    public function getLesFraisHorsForfait($idVisiteur, $mois) {
        $req = "SELECT * FROM lignefraishorsforfait WHERE lignefraishorsforfait.idvisiteur ='$idVisiteur' 
		AND lignefraishorsforfait.mois = '$mois' ";
        $res = PdoGsb::$monPdo->query($req);
        $lesLignes = $res->fetchAll();
        $nbLignes = count($lesLignes);
        for ($i = 0; $i < $nbLignes; $i++) {
            $date = $lesLignes[$i]['date'];
            $lesLignes[$i]['date'] = dateAnglaisVersFrancais($date);
        }
        return $lesLignes;
    }

    /**
     * Fonction qui retourne le nombre de justificatif d'un visiteur 
     * pour un mois donné.
     *
     * @param string $idVisiteur : est l'id du visiteur.
     * @param string $mois : est le mois sous la forme aaaamm.
     * @return int $laLigne['nb'] : est le nombre entier de justificatifs.
     */
    public function getNbjustificatifs($idVisiteur, $mois) {
        $req = "select fichefrais.nbjustificatifs as nb from  fichefrais where fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
        $res = PdoGsb::$monPdo->query($req);
        $laLigne = $res->fetch();
        return $laLigne['nb'];
    }

    /**
     * Fonction qui retourne sous forme d'un tableau associatif toutes 
     * les lignes de frais au forfait concernées par les deux arguments.
     *
     * @param string $idVisiteur : est l'id du visiteur.
     * @param string $mois : est le mois sous la forme aaaamm.
     * @return array $lesLignes : est l'id, le libelle et la quantité sous la forme d'un tableau associatif 
     */
    public function getLesFraisForfait($idVisiteur, $mois) {
        $req = "SELECT fraisforfait.id AS idfrais, fraisforfait.libelle AS libelle, 
                fraisforfait.montant AS montant, lignefraisforfait.quantite AS quantite 
		FROM lignefraisforfait JOIN fraisforfait 
		ON (fraisforfait.id = lignefraisforfait.idfraisforfait)
		WHERE lignefraisforfait.idvisiteur ='$idVisiteur' AND lignefraisforfait.mois='$mois' 
		ORDER BY lignefraisforfait.idfraisforfait";
        $res = PdoGsb::$monPdo->query($req);
        $lesLignes = $res->fetchAll();
        return $lesLignes;
    }

    /**
     * Fonction qui retourne tous les id de la table FraisForfait.
     *
     * @return array $lesLignes : est un tableau associatif.
     */
    public function getLesIdFrais() {
        $req = "select fraisforfait.id as idfrais from fraisforfait order by fraisforfait.id";
        $res = PdoGsb::$monPdo->query($req);
        $lesLignes = $res->fetchAll();
        return $lesLignes;
    }

    /**
     * Procédure qui met à jour la table ligneFraisForfait.
     *
     * Met à jour la table ligneFraisForfait pour un visiteur et
     * un mois donné en enregistrant les nouveaux montants.
     *
     * @param string $idVisiteur : est l'id du visiteur.
     * @param string $mois : est le mois sous la forme aaaamm.
     * @param array $lesFrais : est un tableau de frais.
     */
    public function majFraisForfait($idVisiteur, $mois, $lesFrais) {
        $lesCles = array_keys($lesFrais);
        foreach ($lesCles as $unIdFrais) {
            $qte = $lesFrais[$unIdFrais];
            $req = "UPDATE lignefraisforfait SET lignefraisforfait.quantite = $qte
			WHERE lignefraisforfait.idvisiteur = '$idVisiteur' AND lignefraisforfait.mois = '$mois'
			AND lignefraisforfait.idfraisforfait = '$unIdFrais'";
            PdoGsb::$monPdo->exec($req);
        }
    }

    /**
     * Procédure qui permet de changer le mois d'une ligne de frais hors forfait.
     * 
     * @param string $idHF : est l'id du frais hors forfait.
     * @param string $mois : est le nouveau mois pour la ligne de frais hors forfait.
     */
    public function majLigneFraisHF($idHF, $mois) {
        $req = "UPDATE lignefraishorsforfait SET mois = $mois 
		WHERE id = '$idHF'";
        PdoGsb::$monPdo->exec($req);
    }

    /**
     * Fonction qui retourne le mois de la ligne frais hors forfait
     * avec l'id passé en paramètre.
     * 
     * @param int $idHF : est l'id de la ligne de frais hors forfait.
     * @return string $mois : est le mois de la ligne hors forfait (aaaaMM)
     */
    public function getMoisFicheHF($idHF) {
        $req = "SELECT mois FROM lignefraishorsforfait WHERE id = '$idHF'";
        $res = PdoGsb::$monPdo->query($req);
        $laLigne = $res->fetch();
        $mois = $laLigne['mois'];
        return $mois;
    }

    /**
     * Procédure qui met à jour le nombre de justificatifs de la table ficheFrais
     * pour le mois et le visiteur concerné.
     *
     * @param string $idVisiteur : est l'id du visiteur.
     * @param string $mois : est le mois sous la forme aaaaMM.
     * @param int $nbJustificatifs : est le nombre de justificatifs.
     */
    public function majNbJustificatifs($idVisiteur, $mois, $nbJustificatifs) {
        $req = "UPDATE fichefrais SET nbjustificatifs = $nbJustificatifs 
		WHERE fichefrais.idvisiteur = '$idVisiteur' AND fichefrais.mois = '$mois'";
        PdoGsb::$monPdo->exec($req);
    }

    /**
     * Fonction qui teste si un visiteur possède une fiche de frais 
     * pour le mois passé en argument.
     *
     * @param string $idVisiteur : est l'id du visiteur.
     * @param string $mois : est le mois sous la forme aaaaMM.
     * @return bool $ok : est un booléen vrai ou faux.
     */
    public function estPremierFraisMois($idVisiteur, $mois) {
        $ok = false;
        $req = "SELECT COUNT(*) AS 'nblignesfrais' 
                FROM fichefrais 
		WHERE fichefrais.mois = '$mois' AND fichefrais.idvisiteur = '$idVisiteur'";
        $res = PdoGsb::$monPdo->query($req);
        $laLigne = $res->fetch();
        if ($laLigne['nblignesfrais'] == 0) {
            $ok = true;
        }
        return $ok;
    }

    /**
     * Fonction qui teste si un visiteur possède une fiche de frais 
     * pour le mois passé en argument. Cette fonction sert au comptable.
     *
     * @param string $idVisiteur : est l'id du visiteur.
     * @param string $mois : est le mois sous la forme aaaaMM.
     * @return bool $ok : est un booléen vrai ou faux 
     */
    public function estPremierFraisMoisPourCmp($idVisiteur, $mois) {
        $ok = false;
        $req = "SELECT COUNT(*) AS 'nblignesfrais' 
                FROM fichefrais 
		WHERE fichefrais.mois = '$mois' AND fichefrais.idvisiteur = '$idVisiteur'";
        $res = PdoGsb::$monPdo->query($req);
        $laLigne = $res->fetch();
        if ($laLigne['nblignesfrais'] == 1) {
            $ok = true;
        }
        return $ok;
    }

    /**
     * Fonction qui retourne le dernier mois en cours d'un visiteur.
     *
     * @param string $idVisiteur : est l'id du visiteur.
     * @return string $dernierMois : est le dernier mois en cours aaaaMM.
     */
    public function dernierMoisSaisi($idVisiteur) {
        $req = "SELECT MAX(mois) AS dernierMois FROM fichefrais WHERE fichefrais.idvisiteur = '$idVisiteur'";
        $res = PdoGsb::$monPdo->query($req);
        $laLigne = $res->fetch();
        $dernierMois = $laLigne['dernierMois'];
        return $dernierMois;
    }

    /**
     * Procédure qui crée une nouvelle fiche de frais et les lignes 
     * de frais au forfait pour un visiteur et un mois donnés.
     *
     * Récupère le dernier mois en cours de traitement, met à 'CL' 
     * son champs idEtat, crée une nouvelle fiche de frais
     * avec un idEtat à 'CR' et crée les lignes de frais forfait de 
     * quantités nulles .
     * 
     * @param string $idVisiteur : est l'id du visiteur.
     * @param string $mois : est le mois sous la forme aaaaMM
     */
    public function creeNouvellesLignesFrais($idVisiteur, $mois) {

        $dernierMois = $this->dernierMoisSaisi($idVisiteur);
        $laDerniereFiche = $this->getLesInfosFicheFrais($idVisiteur, $dernierMois);
        if ($laDerniereFiche['idEtat'] == 'CR') {
            $this->majEtatFicheFrais($idVisiteur, $dernierMois, 'CL');
        }
        $req = "INSERT INTO fichefrais(idvisiteur,mois,nbJustificatifs,montantValide,dateModif,idEtat) 
		VALUES('$idVisiteur','$mois',0,0,now(),'CR')";
        PdoGsb::$monPdo->exec($req);
        $lesIdFrais = $this->getLesIdFrais();
        foreach ($lesIdFrais as $uneLigneIdFrais) {
            $unIdFrais = $uneLigneIdFrais['idfrais'];
            $req = "INSERT INTO lignefraisforfait(idvisiteur,mois,idFraisForfait,quantite) 
			VALUES('$idVisiteur','$mois','$unIdFrais',0)";
            PdoGsb::$monPdo->exec($req);
        }
    }

    /**
     * Procédure qui crée un nouveau frais hors forfait pour un visiteur 
     * un mois donné à partir des informations fournies en paramètre.
     *
     * @param string $idVisiteur : est l'id du visiteur. 
     * @param string $mois : est le mois sous la forme aaaaMM.
     * @param string $libelle : est le libelle du frais.
     * @param string $date : est la date du frais au format français jj//mm/aaaa.
     * @param real $montant : est le montant.
     */
    public function creeNouveauFraisHorsForfait($idVisiteur, $mois, $libelle, $date, $montant) {
        $dateFr = dateFrancaisVersAnglais($date);
        $req = "insert into lignefraishorsforfait
            VALUES(DEFAULT,'$idVisiteur','$mois','$libelle','$dateFr','$montant')";

        PdoGsb::$monPdo->exec($req);
    }

    /**
     * Procédure qui supprime le frais hors forfait dont l'id est 
     * passé en argument.
     * 
     * @param int $idFrais : est l'id du frais.
     */
    public function supprimerFraisHorsForfait($idFrais) {
        $req = "DELETE FROM lignefraishorsforfait WHERE id = $idFrais ";
        PdoGsb::$monPdo->exec($req);
    }
    
    /**
     * Procédure de suppression de tous les frais hors forfait d'un mois
     * passé en paramètre et de l'id du visiteur
     * 
     * @param $idVisiteur : est l'id du visiteur.
     * @param $mois : est le mois sous la forme aaaaMM.
     */
    public function supprimeToutFraisHf($idVisiteur, $mois) {
        $req = "DELETE FROM lignefraishorsforfait WHERE idVisiteur = '".$idVisiteur
                ."' AND mois = '".$mois."'";
        PdoGsb::$monPdo->exec($req);
    }

    /**
     * Fonction qui retourne les mois pour lesquels un visiteur 
     * a une fiche de frais.
     *
     * @param string $idVisiteur : est l'id du visiteur.
     * @return array $lesMois est un tableau associatif de clé un mois -aaaamm- et de valeurs l'année et le mois correspondant.
     */
    public function getLesMoisDisponibles($idVisiteur) {
        $req = "SELECT fichefrais.mois AS mois FROM  fichefrais WHERE fichefrais.idvisiteur ='$idVisiteur' 
		ORDER BY fichefrais.mois DESC ";
        $res = PdoGsb::$monPdo->query($req);
        $lesMois = array();
        $laLigne = $res->fetch();
        while ($laLigne != null) {
            $mois = $laLigne['mois'];
            $numAnnee = substr($mois, 0, 4);
            $numMois = substr($mois, 4, 2);
            $lesMois["$mois"] = array(
                "mois" => "$mois",
                "numAnnee" => "$numAnnee",
                "numMois" => "$numMois"
            );
            $laLigne = $res->fetch();
        }
        return $lesMois;
    }

    /**
     * Fonction qui retourne les informations d'une fiche de frais 
     * d'un visiteur pour un mois donné.
     *
     * @param string idVisiteur : est l'id du visiteur.
     * @param string $mois : est le mois sous la forme aaaaMM.
     * @return array $laLigne : est un tableau avec des champs de jointure entre une fiche de frais et la ligne d'état 
     */
    public function getLesInfosFicheFrais($idVisiteur, $mois) {
        $req = "SELECT fichefrais.idEtat AS idEtat, fichefrais.dateModif AS dateModif, fichefrais.nbJustificatifs AS nbJustificatifs, 
			fichefrais.montantValide AS montantValide, etat.libelle AS libEtat 
                        FROM  fichefrais JOIN etat ON (fichefrais.idEtat = etat.id) 
			WHERE fichefrais.idvisiteur ='$idVisiteur' and fichefrais.mois = '$mois'";
        $res = PdoGsb::$monPdo->query($req);
        $laLigne = $res->fetch();
        return $laLigne;
    }

    /**
     * Procédure qui modifie l'état et la date de modification d'une fiche de frais
     * et modifie le champ idEtat et met la date de modif à aujourd'hui.
     * 
     * @param strins $idVisiteur : est l'id du visiteur.
     * @param string $mois : est le mois sous la forme aaaaMM.
     * @param string $etat : est l'état de la fiche.
     */
    public function majEtatFicheFrais($idVisiteur, $mois, $etat) {
        $req = "UPDATE fichefrais SET idEtat = '$etat', dateModif = NOW() 
		WHERE fichefrais.idvisiteur ='$idVisiteur' AND fichefrais.mois = '$mois'";
        PdoGsb::$monPdo->exec($req);
    }

    /**
     * Procédure qui modifie l'état, le montant et le nombre de 
     * justificatifs de la fiche de frais un calcul est fait 
     * directement dans cette procédure.
     * 
     * @param string $idVisiteur : est l'id du visiteur.
     * @param string $mois : est le mois sous la forme aaaaMM.
     * @param string $etat : est l'état de la fiche.
     */
    public function majEtatFicheFraisJustMont($idVisiteur, $mois, $etat) {
        
        require_once('fct.inc.php');
        
        //Récupération des frais
        $lesLignesFrais = $this->getLesFraisForfait($idVisiteur, $mois);

        //Calcul des frais
        $montant = $lesLignesFrais[3][3] * $lesLignesFrais[3][2]; //Repas
        $montant += $lesLignesFrais[2][3] * $lesLignesFrais[2][2]; //Nuité
        $montant += $lesLignesFrais[0][3] * $lesLignesFrais[0][2]; //Etape
        $montant += $lesLignesFrais[1][3] * $lesLignesFrais[1][2]; //km
        //Récupération des frais hors forfait
        $lesLignesHF = $this->getLesFraisHorsForfait($idVisiteur, $mois);

        //Calcul des frais hors forfait
        foreach ($lesLignesHF as $uneLigneHF) {
            $montant += $uneLigneHF[5];
        }

        //Mise à jour de la fiche frais
        $req = "UPDATE fichefrais SET montantValide = '$montant', "
                ."dateModif = NOW(), idEtat = '$etat' 
		WHERE fichefrais.idvisiteur ='$idVisiteur' AND fichefrais.mois = '$mois'";
        PdoGsb::$monPdo->exec($req);
    }

    /**
     * Fonction qui récupère les couleurs pour chaque éléments par rapport aux
     * préférences de l'utilisateur.
     * 
     * @param int $idCouleur : est l'id de la couleur.
     * @return array $listCouleur : est la liste des paramètres couleurs.
     */
    public function getCharteCouleur($idCouleur) {
        $listCouleurs = array('', '', '', '', '', '');
        if (!empty($idCouleur)) {
            $req = "SELECT navbar, pied, menu, bouton1, bouton2, bouton3 "
                    ."FROM chartecouleur JOIN visiteur (chartecouleur.id = visiteur.idcouleur) "
                    ."WHERE nom = '$idCouleur'";
            $listCouleurs = PdoGsb::$monPdo->query($req);
            
            //Récupération des paramètres
            foreach ($listCouleurs as $listCouleur) { 
            }
        }
        return $listCouleur;
    }

    /**
     * Fonction qui renvoie les tarifs forfaitaires.
     * 
     * @return array $listForfaits : est la liste des tarifs forfaitaires.
     */
    public function getTarifForfait() {

        $req = "SELECT id, montant "
                ."FROM fraisforfait";
        $res = PdoGsb::$monPdo->query($req);
        $listTarifs = $res->fetchAll();

        return $listTarifs;
    }

}
?>
