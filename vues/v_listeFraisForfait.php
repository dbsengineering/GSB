<div id="contenu">
    <div class="container">
        <h2>Renseigner ma fiche de frais du mois <?php echo $numMois . "-" . $numAnnee ?></h2>

        <form method="POST"  action="index.php?uc=gererFrais&action=validerMajFraisForfait">
            <div id="divFichF">
                <div class="corpsForm">

                    <fieldset>
                        <legend>Frais forfaitisés
                        </legend>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Libellé</th>
                                        <th>Quantite</th>
                                        <th>Montant unitaire</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        $i = 0;
                                        while($i<4){
                                            $idFrais = $lesFraisForfait[$i]['idfrais'];
                                            $libelle = $lesFraisForfait[$i]['libelle'];
                                            $quantite = $lesFraisForfait[$i]['quantite'];
                            
                                            $montant = $lesFraisForfait[$i+4]['montant'];
                                            $total = $montant * $quantite;
                                    ?>
                                    <tr class="pair">
                                        <td>
                                            <label id="idLabel" for="idFrais"><?php echo $libelle ?></label>
                                        </td>
                                        <td class="022015-a17">
                                            <label for="ETP"><input type="tel" class="fraisForfait" name="lesFrais[<?php echo $idFrais ?>]" id="idFrais" value="<?php echo $quantite ?>" />
                                            </label>
                                        </td>
                                        <td class="montantForfait">
                                            <label for="ETP"><?php echo $montant ?> €</label>
                                        </td>
                                        <td class="total right">
                                            <label for="ETP"><?php echo $total ?> €</label>
                                        </td>
                                    </tr>     
                                    <?php
                                            $i++;
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </fieldset>
                </div>
                <br><br>
                <div class="piedForm">
                    <p>
                        <input id="ok" class="btnVal" type="submit" value="Valider / Modifier" size="20" />
                        <input id="annuler" class="btnVal" type="reset" value="Effacer" size="20" />
                    </p> 
                </div>
            </div>
        </form>
    </div>
