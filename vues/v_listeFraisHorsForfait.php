<br>
<table class="table">
  	   <caption>Descriptif des éléments hors forfait
       </caption>
             <tr>
                <th class="date">Date</th>
				<th class="libelle">Libellé</th>  
                <th class="montant">Montant</th>  
                <th class="action">&nbsp;</th>              
             </tr>
          
    <?php    
	    foreach( $lesFraisHorsForfait as $unFraisHorsForfait) 
		{
			$libelle = $unFraisHorsForfait['libelle'];
			$date = $unFraisHorsForfait['date'];
			$montant=$unFraisHorsForfait['montant'];
			$id = $unFraisHorsForfait['id'];
	?>		
            <tr>
                <td> <?php echo $date ?></td>
                <td><?php echo $libelle ?></td>
                <td><?php echo $montant ?></td>
                <td><a href="index.php?uc=gererFrais&action=supprimerFrais&idFrais=<?php echo $id ?>" 
				onclick="return confirm('Voulez-vous vraiment supprimer ce frais?');">Supprimer ce frais</a></td>
             </tr>
	<?php		 
          
          }
	?>	  
                                          
    </table>
       <div class="container">
      <form action="index.php?uc=gererFrais&action=validerCreationFrais" method="post">
          <div id="divFichF">
      <div class="corpsForm">
         
          <fieldset>
            <legend class="legendeHF">Frais au forfait
            </legend>
            <p>
              <label id="idTxtDateHF" for="txtDateHF">Date (jj/mm/aaaa): </label>
              <input type="text" id="txtDateHF" name="dateFrais" size="10" maxlength="10" value=""  />
            </p>
            <p>
              <label id="idTxtLibelleHF" for="txtLibelleHF">Libellé</label>
              <input type="text" id="txtLibelleHF" name="libelle" size="10"  maxlength="256" value="" />
            </p>
            <p>
              <label id="idTxtMontantHF" for="txtMontantHF">Montant : </label>
              <input type="text" id="txtMontantHF" name="montant" size="10" maxlength="10" value="" />
            </p>
          </fieldset>
      </div>
              <br><br><br><br>
      <div class="piedForm">
          
      <p>
        <input id="ajouter" class="btnVal" type="submit" value="Ajouter" size="20" />
        <input id="effacer" class="btnVal" type="reset" value="Effacer" size="20" />
      </p> 
      </div>
        </div>
      </form>
       </div>
  </div>
  

