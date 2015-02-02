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
                            <script type="text/javascript" src="js/listCommer.js"></script>
                            <div id='jqxWidget'></div>
                    </div>
                    <div id="idDateMois">
                        <p> Mois: <input type="text" id="datepicker"></p>
                        <script type="text/javascript">
                            //Date en lettres et l'année:
                            $(function() {
                                $("#datepicker").datepicker({dateFormat : 'MM (yy)'});
                            });
                            document.getElementById("datepicker").value = getMois()[0] + " (" + getMois()[1].toString() + ")";
                            
                        </script>
                    </div>
                </div>
                <br>
                <h2>Frais au forfait</h2>
                <div id="idTableauVis">
                    <table class="table table-condensed">
                        <tr>
                            <th>Repas midi</th>
                            <th>Nuitée</th>
                            <th>Etape</th>
                            <th>Km</th>
                            <th>Situation</th>
                        </tr>
                        <tr>
                            <td><input id="idRepMidi" type="text" class="form-control" value=""/></td>
                            <td><input id="idNuite" type="text" class="form-control" value=""/></td>
                            <td><input id="idKm" type="text" class="form-control" value=""/></td>
                            <td><input id="idEtape" type="text" class="form-control" value=""/></td>
                            <td><select id="idSelecF" class="clSituation" size="4" name="decision2">
                                    <option value="E">Enregistré</option>
                                    <option value="V">Validé</option>
                                    <option value="R">Remboursé</option>
                                    <option value="S">Saisie en cours</option>
                                </select></td>
                        </tr>
                    </table>
                </div>
                <br>
                <h2>Hors forfait</h2>
                <div id="idTableauVis">
                    <table class="table table-condensed">
                        <tr>
                            <th>Date</th>
                            <th>Libellé</th>
                            <th>Montant</th>
                            <th>Situation</th>
                        </tr>
                        <tr>
                            <td><input id="idDate" type="text" class="form-control" value=""/></td>
                            <td><input id="idLibelle" type="text" class="form-control" value=""/></td>
                            <td><input id="idMontant" type="text" class="form-control" value=""/></td>
                            <td><select class="clSituation" size="4" name="decision2">
                                    <option value="E">Enregistré</option>
                                    <option value="V">Validé</option>
                                    <option value="R">Remboursé</option>
                                    <option value="S">Saisie en cours</option>
                                </select></td>
                        </tr>
                    </table>
                </div>
                <br>
                <h2>Hors Classification</h2>
                <div id="idTableauVis">
                    <table class="table table-condensed">
                        <tr>
                            <th>Nb Justificatifs</th>
                            <th>Montant</th>
                            <th>Situation</th>
                        </tr>
                        <tr>
                            <td><input type="text" class="form-control" value=""/></td>
                            <td><input type="text" class="form-control" value=""/></td>
                            <td><select class="clSituation" size="4" name="decision2">
                                    <option value="E">Enregistré</option>
                                    <option value="V">Validé</option>
                                    <option value="R">Remboursé</option>
                                    <option value="S">Saisie en cours</option>
                                </select></td>
                        </tr>
                    </table>
                </div>
                <br>
                <div class="piedForm">
                    <p>
                        <input id="annuler" class="btnVal" type="reset" value="Effacer" size="20" />
                        <input id="modifier" class="btnVal" type="reset" value="Modifier" size="20" />
                        <input id="ok" class="btnVal" type="submit" value="Envoyer" size="20" />
                    </p> 
                </div>
            </form><!-- fin form -->
        </div>
    </div>
</div>