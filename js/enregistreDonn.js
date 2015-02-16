/**
* enregistreDonn.js
*/

/** 
 * Boite à outils qui permet la validation, la modification et 
 * le remboursement d'une fiche de frais.
 *
 * @copyright   2014-2015 CAVRON Jérémy
 * @package     JS
 * @author      Cavron Jérémy
 * @version     v 1.0
 */

/**
 * Fonction qui retourne l'id du Visiteur sélectionné
 * 
 * @returns {string} idVisiteur
 */
function getIdVisiteur(){
    var idVisiteur;
    var indexSel = $('#jqxWidget').jqxComboBox('selectedIndex');
    idVisiteur = $('#idId' + indexSel).text();//Récupération de l'id du commercial sélectionné par le div idId
    return idVisiteur ;
}

/**
 * Fonction qui retourne la date du jour en format jj/MM/aaaa
 * 
 * @returns {String} laDate
 */
function getDateModif(){
    
    //Création des variables de dates seulement pour l'affichage direct après modification.
    var maintenant=new Date();
    var jour=maintenant.getDate();
    var mois=maintenant.getMonth()+1;
    mois = mois < 10 ? "0" + (mois) : mois;
    var an=maintenant.getFullYear();
    
    var laDate = jour+"/"+mois+"/"+an;
    
    return laDate;
}

/**
 * Procédure qui calcul le montant validé et l'affiche dans 
 * la case "Montant validé".
 */
function calculMontant(){
    var calculTotal;
    
    //EtatFiche
    var montantValid = $('#idMontantVal');

    //Frais forfait
    var repas = $('#idRepas');
    var nuite = $('#idNuite');
    var etape = $('#idEtape');
    var km = $('#idKm');


    //Résumé
    var idNbJus = $('#idNbJus');
    var idMontC = $('#idMontC');
    
    var listT = new Array();
    
    //Récupération des tarifs
    $.post('./controleurs/c_enregistreDonn.php', {postNumFunc: "3"}, function (listTarifs) {
        listT = jQuery.parseJSON(listTarifs);
        
        calculTotal = (repas.val()*listT[3].montant);//Calcul repas
        calculTotal = (nuite.val()*listT[2].montant);//Calcul nuité
        //calculTotal = (etape.val()*listT[0].montant);//Calcul fofait étape

    });
    
}

/**
 * Procédure qui permet d'activer le remboursement d'une fiche.
 */
function rembourser(){

    var annMois = $("#lstMois").val();
    
    //Envoi des données pour validé le remboursement
    $.ajax({
        type: "POST",
        url: "./controleurs/c_enregistreDonn.php",
        data: "postId=" + getIdVisiteur() + "&postMois=" + annMois + "&postNumFunc=1",
         success: function(msg){
                     alert( "Remboursement validé pour cette fiche. " + msg );//Message de confirmation ou d'erreur
                  }
    });

        //une fois le remboursement validé, on  cache le bouton "Remboursement"
        document.getElementById("idRembour").style.visibility = "hidden";
        //Fiche validée et remboursée: bloquage sur modification
        document.getElementById("case3").checked = true;
        document.getElementById("case2").checked = true;
        document.getElementById("idCheck3").style.textDecoration = "none";
        document.getElementById("idCheck2").style.textDecoration = "none";
        document.getElementById("idCheck3").style.color = "#0000FF";
        document.getElementById("idCheck2").style.color = "#01DF01";
        $('#idEtatFiche').html("Etat : " + "Saisie validée et remboursée depuis le " + getDateModif());
}

/**
 * Procédure qui permet de valider une fiche
 * et affiche le montant total.
 */
function valider(){
    
    var annMois = $("#lstMois").val();
    var nbJustif = $('#idNbJus').val();

    //Envoi des données pour validé le remboursement
    $.post('./controleurs/c_enregistreDonn.php', {postId: getIdVisiteur(), postMois: annMois, 
        postJustif: nbJustif, postNumFunc: "0"}, function (leMontant) {
        
        //une fois la fiche validé, on  cache le bouton "modifier" et "valider"
        document.getElementById("idModif").style.visibility = "hidden";
        document.getElementById("idValider").style.visibility = "hidden";
        
        //Fiche validée et remboursée: bloquage sur modification
        document.getElementById("case2").checked = true;
        document.getElementById("case1").checked = false;
        document.getElementById("idCheck1").style.textDecoration ="none";
        document.getElementById("idCheck1").style.textDecoration ="line-through";
        document.getElementById("idCheck1").style.color ="#BBBBBB";
        document.getElementById("idCheck2").style.color ="#01DF01";
        document.getElementById("idRembour").style.visibility = "visible";
        document.getElementById('idMontC').value = leMontant + " €";
        $('#idEtatFiche').html("Etat : " + "Saisie validée depuis le " + getDateModif());
        
    });
    alert( "Validation effectuée pour cette fiche. ");
}

/**
 * Procédure qui permet de modifier les données dans la base de données
 */
function modifier() {

    var annMois = $("#lstMois").val();
    var nbJustif = $('#idNbJus').val();

    $.ajax({
        type: "POST",
        url: "./controleurs/c_enregistreDonn.php",
        data: "postId=" + getIdVisiteur() + "&postMois=" + annMois + "&postJustif=" + nbJustif
                + "&postTabFrais=" + JSON.stringify(recuperFraisF()) + "&postNumFunc=2",
        success: function (msg) {
            alert("Modification effectuée pour cette fiche. " + msg);//Message de confirmation ou d'erreur
        }
    });
}

/**
 * Fonction qui récupère les frais forfait de l'interface
 * et les retourne sous forme d'un tableau.
 * 
 * @returns {Array()} fraisF
 */
function recuperFraisF(){

    var fraisF = new Array();//Tableau associatif frais forfait

    fraisF[0] = $('#idRepas').val();//Repas
    fraisF[1] = $('#idNuite').val();//nuité
    fraisF[2] = $('#idKm').val();//Km
    fraisF[3] = $('#idEtape').val();//Etape
    
    return fraisF;
}
