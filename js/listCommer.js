/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function () {
    
        $.post('./controleurs/c_importVisit.php', function(data){
            var source = new Array();
            source = jQuery.parseJSON(data);
            var html= "";

            $.each(source, function(i, serverData){
               html =  "<div class='contenuCbx'>\n\
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
                        </div>";
                source[i] = {html: html, title: serverData.nom};

            });

            $("#jqxWidget").jqxComboBox({source: source, selectedIndex: 0, width: '250', height: '50px'});
        });
});