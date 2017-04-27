<div id="selVisiteur">

    <h3>Visiteurs: </h3>

    <form action="index.php?uc=<?php echo $_REQUEST['uc']?>&action=selection" method="post">


      <div class="corpsForm">

      <p>

        <label for="idDuVisiteur">Visiteur : </label>
        <select id="idDuVisiteur" name="idDuVisiteurSelectionne">
            <?php

            if (!isset($leVisiteurSelectionne)) { $leVisiteurSelectionneId = 0;}


			foreach ($arrayVisiteur as $leVisiteurASelectionner)
			{
                            ?>
                          <option <?php if($leVisiteurASelectionner['id'] == $leVisiteurSelectionneId){echo 'selected=true';}?> value="<?php echo $leVisiteurASelectionner['id'] ?>">
                              <?php echo  $leVisiteurASelectionner['nom']. ' '. $leVisiteurASelectionner['prenom'] ?>
                          </option>
                          <?php

			}

		   ?>

        </select>
      </p>
      </div>
      <div class="piedForm">
      <p>
        <input id="ok" type="submit" value="Valider" size="20" />
        <input id="annuler" type="reset" value="Effacer" size="20" />
      </p>
      </div>
    </form>

<?php if (isset($leVisiteurSelectionneId)) { ?>
        <form action="index.php?uc=<?php echo $_REQUEST['uc']?>&action=validerFicheFrais" method="post">
    <label for="moisSelectionne">Mois : </label>
    <select id="moisSelectionne" name="moisSelectionne">
        <?php
        foreach ($moisDispo as $unMois)
        {
            $mois = $unMois[0]['mois'];
            $annee =  $unMois[0]['annee'];
            $numMois =  $unMois[0]['numMois'];
            $etat = $unMois[1];
            if($mois == $moisASelectionner){
            ?>
            <option selected value="<?php echo $mois ?>"><?php echo  $numMois."/".$annee.' ('.$etat.')' ?> </option>
            <?php
            }
            else{ ?>
            <option value="<?php echo $mois ?>"><?php echo  $numMois."/".$annee.' ('.$etat.')' ?> </option>
            <?php
            }

        }

       ?>
       <input type="hidden" name="idDuVisiteurSelectionne" value="<?php echo $leVisiteurSelectionneId; ?>">

    </select>
  </p>
  </div>
  <div class="piedForm">
  <p>
    <input id="ok" type="submit" value="Valider" size="20" />
    <input id="annuler" type="reset" value="Effacer" size="20" />
  </p>
  </div>

  </form>
<?php } ?>



</div>
