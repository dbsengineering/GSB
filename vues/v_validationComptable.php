<div id="contenu">
    <div class="container">
    <h2>Validation des Frais par visiteur</h2>

    <form method="POST"  action="index.php?uc=gererFrais&action=validerMajFraisForfait">
        <div id="divFichF">
        <div class="corpsForm">
            <br>
            <fieldset>
                
                <div id="divCadreFichComp">

                    <script type="text/javascript" src="js/listCommer.js"></script>

                <p>Choisir le visiteur : <div id='jqxWidget'></div></p>
                <!-- <div id="btnn" style="width: 30px; height: 30px;background: #444444;"></div> -->
                <br>
                <p> Mois: <input type="text" id="datepicker"></p>
                </div>
                <script type="text/javascript">
                    //Date :
                    $(function() {
                        
                        $( "#datepicker" ).datepicker({dateFormat : 'MM (yy)'});
                    });
    
                        document.getElementById("datepicker").value = getMois()[0] + " (" + getMois()[1].toString() + ")";

                </script>
        </div>
        </div>
    </form>
    </div>
</div>