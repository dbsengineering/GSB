<div id="contenu">
    <div class="container">
    <h2>Renseigner ma fiche de frais du mois <?php echo $numMois . "-" . $numAnnee ?></h2>

    <form method="POST"  action="index.php?uc=gererFrais&action=validerMajFraisForfait">
        <div id="divFichF">
        <div class="corpsForm">

            <fieldset>
                <legend>Frais forfaitisés
                </legend>
                
                <?php
                    foreach ($lesFraisForfait as $unFrais) {
                    $idFrais = $unFrais['idfrais'];
                    $libelle = $unFrais['libelle'];
                    $quantite = $unFrais['quantite'];
                ?>
                    
                    <p>
                        <label id="idLabel" for="idFrais"><?php echo $libelle ?></label>

                        <input type="text" id="idFrais" name="lesFrais[<?php echo $idFrais ?>]" size="10" maxlength="5" value="<?php echo $quantite ?>" />
                    </p>
                    
                <?php
                    }
                ?>
            </fieldset>
        </div>
            <br><br>
        <div class="piedForm">
            <p>
                <input id="ok" class="btnVal" type="submit" value="Valider" size="20" />
                <input id="annuler" class="btnVal" type="reset" value="Effacer" size="20" />
            </p> 
        </div>
        </div>
    </form>
    </div>