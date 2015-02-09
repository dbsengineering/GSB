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
    //permet de récupérer la valeur Année/Mois sélectionnée.
    getAnnMoisSelect();

});



/**
 * Procédure qui crée des lignes dans la section hors forfait
 * suivant le nombre de lignes en paramètre.
 * @param laDate Données a intégrer dans les lignes.
 * @param libelle
 * @param montant
 */
function ajoutLigne(laDate, libelle, montant) {
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
                        <td><input id='idMontant' type='text' class='form-control' value='" + montant + "'/></td>\n\
                        <td><select class='clSituation' size='4' name='decision2'>\n\
                            <option value='E'>Enregistré</option>\n\
                            <option value='V'>Validé</option>\n\
                            <option value='R'>Remboursé</option>\n\
                            <option value='S'>Saisie en cours</option>\n\
                        </select></td><td>\n\
                        <button type='button' style='cursor:pointer; width: 100px; color:#000;' onclick='\n\
                        if (confirm(&quot;Voulez-vous vraiment reporter cette ligne?&quot;)){ alert(&quot;Reportation&quot;)}'>Reporter</button><br><br>\n\
                        <button type='button' style='cursor:pointer; width: 100px; color:#000;' onclick='\n\
                        if (confirm(&quot;Voulez-vous vraiment supprimer cette ligne?&quot;)){ effacer(this.parentNode.rowIndex)}'>Supprimer</button></td>";
}


/**
 * Fonction pour confirmer un message.
 * @param index
 * @param message . est le message
 * @returns confirm(message). Est la confirmation du message
 */
function confirmer(index, message) {
    return confirm(message);
    effacer(index);
    // confirmer(this.parentNode.rowIndex, 'Voulez-vous vraiment supprimer cette ligne?');
}

/**
 * Procédure qui efface les données de l'interface sans les 
 * effacer sur la base de données.
 * @param num est le numéro de lignes qu'il y a dans Hors forfait.
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
 * @param  idVisiteur est l'id du visiteur passé en paramètre. de type chaîne.
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
 * Fonction qui permet de retourner la valeur Année/mois
 * Dès qu'on sélectionne un mois différent dans la liste
 * de l'interface.
 * @returns annMois . Est la valeur Année/Mois.
 */
function getAnnMoisSelect() {
    $('#lstMois').on('change', function (event) {
        var annMois = $(this).val();
        //Frais forfait
var repMidi = $('#idRepMidi');
var nuite = $('#idNuite');
var etape = $('#idEtape');
var km = $('#idKm');


//Hors classification
var idNbJus = $('#idNbJus');
var idMontC = $('#idMontC');

var donnees = new Array();
        effacer(0);//On efface les données de l'interface
        //Récupération des informations "frais" du commercial sélectionné
        $.post('./controleurs/c_importFraisAValid.php', {postId: idVisiteur, postMois: annMois}, function (donn) {

            //Si il n'y a pas d'erreurs dans les données récupérées
            //Alors on affecte les données aux div
            donn = donn.substring(1, donn.length);
 

            if (donn !== "0") {

                donnees = jQuery.parseJSON(donn);

      
                repMidi.val(donnees[3].quantite);//Renvoi les frais repas midi
                nuite.val(donnees[2].quantite);//Renvoi les frais nuités
                etape.val(donnees[0].quantite);//Renvoi les frais Etape
                km.val(donnees[1].quantite);//Renvoi les frais km

                //Vérifie l'état des frais et sélectionne le bon état sur l'interface
                switch (donnees.idEtat) {
                    case "CL":
                        $("option[value='E']").attr("selected", "selected");
                        break;
                    case "VA":
                        $("option[value='V']").attr("selected", "selected");
                        break;
                    case "RB":
                        $("option[value='R']").attr("selected", "selected");
                        break;
                    case "CR":
                        $("option[value='S']").attr("selected", "selected");
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

                        ajoutLigne(donnees[k].date, donnees[k].libelle, donnees[k].montant);

                        k++;
                    }
                }

                //Hors classification
                idNbJus.val(donnees.nbJustificatifs);
                idMontC.val(donnees.montantValide + " €");
            }
        });
    });
}

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