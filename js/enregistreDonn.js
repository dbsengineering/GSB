/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function rembourser(){
    alert();
    var idVisiteur;
    var indexSel = $('#jqxWidget').jqxComboBox('selectedIndex');
    var annMois = $("#lstMois").val();
    
    
    
    idVisiteur = $('#idId' + indexSel).text();//Récupération de l'id du commercial sélectionné par le div idId
    
    
    $.post('./controleurs/c_enregistreDonn.php', {postId: idVisiteur, postMois: annMois, postNumFunc: 1}, function () {
        
        //une fois le remboursement validé, on désactive et cache le bouton "Remboursement"
        document.getElementById("idRembour").disabled = false;
        document.getElementById("idRembour").style.visibility = "hidden";
    });
}