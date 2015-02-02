/**
 * listCommer.js

 * Procédure qui permet d'initialiser
 * le comboBox avec tous les renseignements des commerciaux.
 * Lors d'un clic sur un commercial, la procédure récupère
 * les données des frais de l'intéressé et du mois indiqué.

 * @author Cavron Jérémy
 */






/**
 * Action au chargement de la page
 * @param {type} param
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
                    "<div id='idId"+ i +"' style='visibility:hidden;'>" + serverData.id + "</div>";//Div cachée pour l'id

            //Affichage du nom et prénom dans le cadre de la ComboBox une fois sélectionné un commercial.
            source[i] = {html: html, title: serverData.nom + " " + serverData.prenom};
        });

        //Cadre Text du ComboBox + affichage du premier nom de la liste.
        $("#jqxWidget").jqxComboBox({source: source, selectedIndex: 0, width: '250', height: '50px'});


        //Récupération de l'item sélectionné. ensuite récupération des informations liées à l'id visiteur
        $('#jqxWidget').bind('select', function (event) {
            
            effaceDonn();//On efface les données de l'interface
            
            //Déclaration des variables globales

            //Frais forfait
            var repMidi = $('#idRepMidi');
            var nuite = $('#idNuite');
            var etape = $('#idEtape');
            var km = $('#idKm');
            var etatForfait;

            //Frais hors forfait
            var dateF = $('#idDate');
            var libelle = $('#idLibelle');
            var montant = $('#idMontant');
            
            //Récupérer l'index sélectionné
            var indexSel = $('#jqxWidget').jqxComboBox('selectedIndex');
            
            var idVisiteur = $('#idId'+ indexSel).text();//Récupération de l'id du commercial sélectionné par le div idId
            
            var annMois = getMoisChiffre($('#datepicker').val());//Conversion du mois

            var donnees = new Array();
            //, { postId: idVisiteur, postMois: annMois }
            //Récupération des informations "frais" du commercial sélectionné
            $.post('./controleurs/c_importFraisAValid.php', { postId: idVisiteur, postMois: annMois }, function (donn) {

                //Si il n'y a pas d'erreurs dans les données récupérées
                //Alors on affecte les données aux div
                donn = donn.substring(1, donn.length);

                if(donn !== "0"){

                    //donn = donn.substring(1, donn.length - 1);

         
                    donnees = jQuery.parseJSON(donn);
                    

                    repMidi.val(donnees[3].quantite);//Renvoi les frais repas midi
                    nuite.val(donnees[2].quantite);//Renvoi les frais nuités
                    etape.val(donnees[0].quantite);//Renvoi les frais Etape
                    km.val(donnees[1].quantite);//Renvoi les frais km
                    
                    //Vérifie l'état des frais et sélectionne le bon état sur l'interface
                    switch(donnees.idEtat){
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
                }
            });
        });
    });

});

/**
 * Procédure qui efface les données de l'interface.
 */
function effaceDonn(){
    $('#idRepMidi').val("");//Efface les frais repas midi
    $('#idNuite').val("");//Efface les frais nuités
    $('#idEtape').val("");//Efface les frais Etape
    $('#idKm').val("");//Efface les frais km
}

     