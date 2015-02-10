<div id="contenu">
    <div class="container">
        <h2>Validation des Frais par visiteur</h2>
        <div id="divCadreFichComp">
            <form method="POST"  action="index.php?uc=gererFrais&action=validerMajFraisForfait">
                <div id="divFichF">
                    <div class="listeVisit">

                        <div class="arrow">
                        Choisir le visiteur :
                        </div>
                            <script type="text/javascript" src="js/enregistreDonn.js"></script>
                            <script type="text/javascript" src="js/listCommer.js"></script>
                            <div id='jqxWidget'></div>
                    </div>
                    <div id="idDateMois">
                        <p><label class="titre">Mois :</label> 
                            <select id="lstMois" name="lstMois" style="width:200px; color:#000;">
                                <option selected value="0">Sélectionner une date</option>
                         

                        </select> <!--<input type="text" id="datepicker"> --></p>
                        
                    </div>
                </div>
                <br>
                <div id="idEtat">
                    <table class="pagination-centered">
                        <tr>
                            <th><h1><center>Etat de la fiche</center></h1></th>
                        </tr>
                        <tr>
                            <td><div id="idCheck1" class="clCheck">
                                    <label for="enre">Clôturé</label>
                                    <input id="case1" name="enre" type="checkbox" disabled = true><br>
                                </div><br>
                                <div id="idCheck2" class="clCheck">
                                    <label for="vali">Valider</label>
                                    <input id="case2" name="vali" type="checkbox" disabled = true><br>
                                </div><br>
                                <div id="idCheck3" class="clCheck">
                                    <label for="remb">Rembourser</label>
                                    <input id="case3" name="remb" type="checkbox" disabled = true><br>
                                </div><br>
                                <div id="idCheck4" class="clCheck">
                                    <label for="sais">Saisie en cours</label>
                                    <input id="case4" name="sais" type="checkbox" disabled = true><br>
                                </div></td>
                        </tr>
                        <tr>
                            <td><div id="idEtatFiche"></div>
                                <div id="idMontantVal"></div></td>
                        </tr>
                    </table>
                </div>
                <br>
                <h2>Frais au forfait</h2>
                <div id="idTableauVis">
                    <table class="table table-condensed">
                        <tr>
                            <th>Repas</th>
                            <th>Nuitée</th>
                            <th>Etape</th>
                            <th>Km</th>
                        </tr>
                        <tr>
                            <td><input id="idRepMidi" type="text" class="form-control" value=""/></td>
                            <td><input id="idNuite" type="text" class="form-control" value=""/></td>
                            <td><input id="idKm" type="text" class="form-control" value=""/></td>
                            <td><input id="idEtape" type="text" class="form-control" value=""/></td>
                            
                        </tr>
                    </table>
                </div>
                <br>
                <h2>Hors forfait</h2>
                <div id="idTableauVis">
                    <table id="idTableHF" class="table table-condensed">
                        <tr>
                            <th>Date</th>
                            <th>Libellé</th>
                            <th>Montant</th>
                            <th>Options</th>
                        </tr>
                        
                        <!-- code ici -->
                    </table>
                </div>
                <br>
                <h2>Résumé</h2>
                <div id="idTableauVis">
                    <table class="table table-condensed">
                        <tr>
                            <th>Nombre de Justificatifs reçus</th>
                            <th>Montant validé</th>

                        </tr>
                        <tr>
                            <td><input id="idNbJus" type="text" class="form-control" value=""/></td>
                            <td><input id="idMontC" type="text" class="form-control" value=""/></td>

                        </tr>
                    </table>
                </div>
                <br>
                <div class="piedForm">
                    <p>
                        <input id="idModif" class="btnVal" type="button" value="Modifier" size="20" style="visibility:hidden;"/>
                        <input id="idValider" class="btnVal" type="button" value="Valider" size="20" style="visibility:hidden;"/>
                        <input id="idRembour" class="btnVal" type="button" value="Rembourser" size="20" style="visibility:hidden;" onclick="javascript:rembourser();"/>
                    </p> 
                </div>
            </form><!-- fin form -->
        </div>
    </div>
</div>