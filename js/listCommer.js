/**
 * listCommer.js
 
 * Ensemble de traitements pour l'interface comptable.
 * 
 * Procédure qui permet d'initialiser
 * le comboBox avec tous les renseignements des commerciaux.
 * Lors d'un clic sur un commercial, la procédure récupère
 * les mois et années dont le commercial sélectionné aurait des fiches saisies.
 
 * @author Cavron Jérémy
 */


public:
        var k;
var i;
var idVisiteur;




/**
 * Actions au chargement de la page
 */
$(document).ready(function () {



    //Récupération des commerciaux
    $.post('./controleurs/c_importVisit.php', function (data) {
        var source = new Array();
        source = jQuery.parseJSON(data);
        var html = "";

        //Création de la liste à l'intérieur du comboBox
        //Incrémente la liste tant qu'il y a des données dans le tableau source.
        //On crée un div caché pour y mettre l'id du commercial sélectionné.
        $.each(source, function (i, serverData) {
            html = "<div class='contenuCbx'>\n\
                            <img width='60' style='float: left; margin-top: 4px; margin-right: 15px;' src='img/" + serverData.avatar + "'/>\n\
                            <div style='margin-top: 10px; font-size: 13px;'>"
                    + "<b>Nom</b>\n\
                                <div>" + serverData.nom + "\
                                </div>\n\
                                <div style='margin-top: 10px;'>\n\
                                    <b>Prénom</b>\n\
                                    <div>" + serverData.prenom + "\
                                    </div>\n\
                                </div>\n\
                            </div>\n\
                        </div>" +
                    "<div id='idId" + i + "' style='visibility:hidden;'>" + serverData.id + "</div>";//Div cachée pour l'id

            //Affichage du nom et prénom dans le cadre de la ComboBox une fois sélectionné un commercial.
            source[i] = {html: html, title: serverData.nom + " " + serverData.prenom};
        });

        //Cadre Text du ComboBox + affichage du premier nom de la liste.
        $("#jqxWidget").jqxComboBox({source: source, selectedIndex: 0, width: '100%', height: '50px'});

        //Récupération des mois et années des saisies et implémentation sur l'interface leur du premier chargement
        listOpts($('#idId' + $('#jqxWidget').jqxComboBox('selectedIndex')).text());

        idVisiteur = $('#idId' + 0).text();

        //Sélection sur Visiteur
        selectVisit();


    });
    //Activation de la sélection dans la liste des mois.
    //permet d'afficher les frais d'un visiteur.
    recupFraisVisit();

});



/**
 * Procédure qui crée des lignes dans la section hors forfait
 * suivant le nombre de lignes en paramètre.
 * @param laDate Données a intégrer dans les lignes.
 * @param libelle
 * @param montant
 * @param desactiveBtn permet de savoir si on doit afficher les boutons de modification ou pas.
 */
function ajoutLigne(laDate, libelle, montant, desactiveBtn) {
    var tableau = document.getElementById("idTableHF");

    var ligne = tableau.insertRow(-1);//on a ajouté une ligne

    /*Remplacement des quotes dans la variable "libelle" 
     * par la balise HTML (&lsquo;).
     * Permet d'afficher les quotes normalement.
     */
    var reg = new RegExp("'", "g");
    libelle = libelle.replace(reg, "&lsquo;");


    ligne.innerHTML += "<td><input id='idDate' type='text' class='form-control' value='" + laDate + "'/></td>\n\
                        <td><input id='idLibelle' type='text' class='form-control' value='" + libelle + "'/></td>\n\
                        <td><input id='idMontant' type='text' class='form-control' value='" + montant + "'/></td>";
                        if(desactiveBtn){
                            ligne.innerHTML += "<td><button type='button' style='cursor:pointer; width: 100px; color:#000;' onclick='\n\
                            if (confirm(&quot;Voulez-vous vraiment reporter cette ligne?&quot;)){ alert(&quot;Reportation&quot;)}'>Reporter</button><br><br>\n\
                            <button type='button' style='cursor:pointer; width: 100px; color:#000;' onclick='\n\
                            if (confirm(&quot;Voulez-vous vraiment supprimer cette ligne?&quot;)){ effacer(this.parentNode.rowIndex)}'>Supprimer</button></td>";
                        }
}


/**
 * Fonction pour confirmer un message.
 * @param {integer} index
 * @param {string} message . est le message
 * @returns confirm(message). Est la confirmation du message
 */
function confirmer(index, message) {
    return confirm(message);
    //effacer(index);
    // confirmer(this.parentNode.rowIndex, 'Voulez-vous vraiment supprimer cette ligne?');
}

/**
 * Procédure qui efface les données de l'interface sans les 
 * effacer sur la base de données.
 * @param {integer} num est le numéro de lignes qu'il y a dans Hors forfait.
 */
function effacer(num) {
    $('#idRepMidi').val("");//Efface les frais repas midi
    $('#idNuite').val("");//Efface les frais nuités
    $('#idEtape').val("");//Efface les frais Etape
    $('#idKm').val("");//Efface les frais km

    if (num !== 0) {
        document.getElementById("idTableHF").deleteRow(num);
    } else {
        num = document.getElementById('idTableHF').rows.length - 1;

        while (num > 0) {
            document.getElementById("idTableHF").deleteRow(num);
            num--;
        }

    }
}
/**
 * Procédure qui récupère les mois et années de saisies d'un visiteur passé en paramètre
 * et implémente le combobox de l'interface comptable.
 * @param  {string} idVisiteur est l'id du visiteur passé en paramètre. de type chaîne.
 */
function listOpts(idVisiteur) {
    //Appel le composant c_importMoisVisit.php en lui envoyant l'id du visiteur comme paramètre.
    //Ce composant retourne la liste des mois et années saisies du visiteur.
    $.post('./controleurs/c_importMoisVisit.php', {postId: idVisiteur}, function (donnMois) {

        var listMois = new Array();//Création d'une liste
        listMois = jQuery.parseJSON(donnMois);//implémentation de la liste avec les données récupérées

        var select = document.getElementById("lstMois");//Récupération du "select" de l'interface.


        //Supression de la liste des dates sur l'interface
        //Tant que la longueur de select est supérieur à 0
        //Alors on supprime ligne par ligne.
        while (select.length > 1) {
            select.remove(select.length - 1);
        }

        //Boucle sur sur la liste des mois récupérée pour implémenter l'interface
        $.each(listMois, function (i, serverData) {
            //Création d'une option dans le select
            var option = document.createElement("option");
            option.value = serverData.mois;//Valeur de l'option
            option.text = serverData.numMois + "/" + serverData.numAnnee;//Text de l'option
            select.add(option);//On ajout l'option au select
        });
    });
}
/**
 * Procédure qui permet d'afficher les frais d'un visiteur
 * à la date sélectionnée.
 */
function recupFraisVisit() {
    $('#lstMois').on('change', function (event) {
        
                
        var annMois = $(this).val();
        var calculTotal;
        
        var info = $('#idEtatFiche');
        var montantValid = $('#idMontantVal');
        
        //Frais forfait
        var repMidi = $('#idRepMidi');
        var nuite = $('#idNuite');
        var etape = $('#idEtape');
        var km = $('#idKm');


        //Hors classification
        var idNbJus = $('#idNbJus');
        var idMontC = $('#idMontC');
        
        var desactiveBtn = false;//Variable qui sert à savoir si on désactive les boutons de modifications.

        var donnees = new Array();
        effacer(0);//On efface les données de l'interface
        info.html();
        montantValid.html();
        decoCheckBox();//On décoche toutes les cases des checkbox

        
        //Récupération des informations "frais" du commercial sélectionné
        $.post('./controleurs/c_importFraisAValid.php', {postId: idVisiteur, postMois: annMois}, function (donn) {

            //Si il n'y a pas d'erreurs dans les données récupérées
            //Alors on affecte les données aux div
            donn = donn.substring(1, donn.length);
 

            if (donn !== "0") {

                donnees = jQuery.parseJSON(donn);

      
                repMidi.val(donnees[3].quantite);//Renvoi les frais repas midi
                nuite.val(donnees[2].quantite);//Renvoi les frais nuitées
                etape.val(donnees[1].quantite);//Renvoi les frais Etape
                km.val(donnees[0].quantite);//Renvoi les frais km
                
                
                
                calculTotal = (donnees[3].quantite*donnees[3].montant);//Calcul des repas
                calculTotal += (donnees[2].quantite*donnees[2].montant);//Calcul nuitées + rep
                calculTotal += (donnees[1].quantite*donnees[1].montant);//calcul etape + les précédents
                calculTotal += (donnees[0].quantite*donnees[0].montant);//Calcul km + les précédents
                
                
                //Vérifie l'état des frais et sélectionne le bon état sur l'interface
                //+ changement de style.
                switch (donnees.idEtat) {
                    case "CL":
                        //Fiche clôturée: on peut modifier
                        document.getElementById("case1").checked = true;
                        document.getElementById("idCheck1").style.textDecoration ="none";
                        document.getElementById("idCheck1").style.color ="#01DF01";
                        //document.getElementById("idModif").disabled = true;
                        //document.getElementById("idValider").disabled = true;
                        //document.getElementById("idRembour").disabled = false;
                        document.getElementById("idRembour").style.visibility = "hidden";
                        document.getElementById("idModif").style.visibility = "visible";
                        document.getElementById("idValider").style.visibility = "visible";
                        //Afficher les information liés à la saisie
                        info.html("Etat : " + "Saisie clôturée depuis le " + dateAnglVersFran(donnees.dateModif));
                        calculTotal = Math.round(calculTotal*100)/100;//On arrondi à 2 chiffres après la virgule
                        desactiveBtn = true;
                        break;
                    case "VA":
                        //Fiche validée: bloquage sur modification
                        document.getElementById("case2").checked = true;
                        document.getElementById("idCheck2").style.textDecoration ="none";
                        document.getElementById("idCheck2").style.color ="#01DF01";
                        //document.getElementById("idRembour").disabled = true;
                        //document.getElementById("idModif").disabled = false;
                        //document.getElementById("idValider").disabled = false;
                        document.getElementById("idRembour").style.visibility = "visible";
                        document.getElementById("idModif").style.visibility = "hidden";
                        document.getElementById("idValider").style.visibility = "hidden";
                        info.html("Etat : " + "Saisie validée et mise en paiement depuis le " + dateAnglVersFran(donnees.dateModif));
                        
                        desactiveBtn = false;
                        break;
                    case "RB":
                        //Fiche validée et remboursée: bloquage sur modification
                        document.getElementById("case3").checked = true;
                        document.getElementById("case2").checked = true;
                        document.getElementById("idCheck3").style.textDecoration ="none";
                        document.getElementById("idCheck2").style.textDecoration ="none";
                        document.getElementById("idCheck3").style.color ="#0000FF";
                        document.getElementById("idCheck2").style.color ="#01DF01";
                        //document.getElementById("idRembour").disabled = false;
                        //document.getElementById("idModif").disabled = false;
                        //document.getElementById("idValider").disabled = false;
                        document.getElementById("idModif").style.visibility = "hidden";
                        document.getElementById("idValider").style.visibility = "hidden";
                        document.getElementById("idRembour").style.visibility = "hidden";
                        info.html("Etat : " + "Saisie validée et remboursée depuis le " + dateAnglVersFran(donnees.dateModif));
                        desactiveBtn = false;
                        break;
                    case "CR":
                        //Fiche crée, saisie en cours: bloquage sur modification
                        document.getElementById("case4").checked = true;
                        document.getElementById("idCheck4").style.textDecoration ="none";
                        document.getElementById("idCheck4").style.color ="#883322";
                        //document.getElementById("idModif").disabled = false;
                        //document.getElementById("idValider").disabled = false;
                        //document.getElementById("idRembour").disabled = false;
                        document.getElementById("idModif").style.visibility = "hidden";
                        document.getElementById("idValider").style.visibility = "hidden";
                        document.getElementById("idRembour").style.visibility = "hidden";
                        info.html("Etat : " + "Fiche créée, saisie en cours depuis le " + dateAnglVersFran(donnees.dateModif));
                        desactiveBtn = false;
                      
                        break;
                }

                //On vérifie si il existe des frais "hors forfait"
                //Si oui, alors on le récupère dans la liste à partir de l'indice 9.
                //et on affiche. Sinon on n'affiche pas.
                if (donnees[9]) {
                    k = 9;
                    //On Vérifie si on a plusieurs frais en "hors forfait".

                    //Boucle à partir de l'indice 9
                    //pour rajouter des lignes hors forfait sur l'interface.
                    while (donnees[k]) {

                        ajoutLigne(donnees[k].date, donnees[k].libelle, donnees[k].montant, desactiveBtn);

                        calculTotal += parseInt(donnees[k].montant);

                        k++;
                    }
                    calculTotal = Math.round(calculTotal*100)/100;//On arrondi à 2 chiffres après la virgule
                }
                
                
                
                //Hors classification
                idNbJus.val(donnees.nbJustificatifs);
                idMontC.val(donnees.montantValide + " €");
            }
        });
    });
}
/**
 * Procédure lors d'une sélection visiteur.
 */
function selectVisit() {
    //Récupération de l'item sélectionné. ensuite récupération des informations liées à l'id visiteur
    $('#jqxWidget').bind('select', function (event) {

        effacer(0);//On efface les données de l'interface

        //Récupérer l'index sélectionné
        var indexSel = $('#jqxWidget').jqxComboBox('selectedIndex');

        idVisiteur = $('#idId' + indexSel).text();//Récupération de l'id du commercial sélectionné par le div idId

        //Récupération des mois et années des saisies 
        //et implémentation sur l'interface leur d'une sélection
        listOpts(idVisiteur);
    });
}

/**
 * Procédure qui permet de décocher les checkbox (Etat fiche).
 */
function decoCheckBox(){
    for(var i=1;i<=4;i++){
        document.getElementById("case"+i).checked = false;
        document.getElementById("idCheck"+i).style.textDecoration ="line-through";
        document.getElementById("idCheck"+i).style.color ="#BBBBBB";
    }
}

/**
 * Fonction qui récupère une date en version
 * anglophone et retourne cette dernière en version
 * française.
 * @param {string} uneDate
 * @returns {string} dateFr
 */
function dateAnglVersFran(uneDate){
   
    var taille = uneDate.length;//taille de la chaîne date
    var dateFr = "00/00/0000";
    //On vérifie si la date est cohérente en : 0000-00-00
    //Sinon on ne convertie pas et on retourne 00/00/0000
    if(taille === 10){
        var jour = uneDate.substring(8, uneDate.length);//on extrait le jour
        var mois = uneDate.substring(5, 7);//On extrait le mois
        var annee = uneDate.substring(0, 4);//on extrait l'année
        dateFr = jour + "/" + mois + "/" + annee;//On conditionne en date française
        return dateFr;
    }else{
        return dateFr;
    }
}