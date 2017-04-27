<strong>Fiche de frais  <?php echo $mois.'/'.$annee; ?>, <?php echo $visiteurSelectionne['nom'] . ' '. $visiteurSelectionne['prenom'];?> :
</strong>

<li>

<?php
if (isset($validationMessage)){
    echo $validationMessage;
}elseif (isset($_REQUEST['erreurs'])) {

    echo $_REQUEST['erreurs'];
}

echo $erreurs; ?>

 <li/>

    <div class="encadre">

  	   <caption>Eléments forfaitisés </caption>
       <form id="validationForm" action="index.php" method="POST">

       <input type="hidden" name="idDuVisiteurSelectionne" value="<?php echo $visiteurSelectionne['id']; ?>">
       <input type="hidden" name="moisSelectionne" value="<?php echo $moisSelectionne; ?>">

<?php

$libelleFiche = $pdo->getLibelleEtatParId($lesInfosFicheFrais['idEtat'])[1];
$idLibelleFiche = $pdo->getLibelleEtatParId($lesInfosFicheFrais['idEtat'])[0];

$editableForm = false;
if ($idLibelleFiche=='CL'){
      $editableForm = true;
  }


echo '</br>Statut:'.$libelleFiche.'<br/>';
$totalFraisForfait = 0;

foreach ( $lesFraisForfait as $unFraisForfait )
{
    $idFraisForfait =  $unFraisForfait['idfrais'];
    $quantite = $unFraisForfait['quantite'];
    $libelle = $unFraisForfait['libelle'];
    $montant = $unFraisForfait['montant'];
    $totalFraisForfait+=$montant;
?>

    <p>
        <label for="idFrais"><?php echo $libelle ?></label>
        <input type="text" id="idFrais" name="lesFrais[<?php echo $idFraisForfait?>]" size="10" maxlength="5" value="<?php echo $quantite?>" <?php if (!$editableForm) {echo 'disabled'; }?> > (<?php echo  ''.floatval($quantite) * floatval($montant).' euros' ;?>)</br>
    </p>

		 <?php
     }

echo '</br>Montant total forfait:'.$totalFraisForfait;
?></br><?php
if ($editableForm){?>
    <button onclick="triggerButton('?uc=validerFrais&action=modifierFraisForfait','validationForm' );" type="button">Modifier</button>

<?php     }
		?>
    </p>
    <p>
        <?php if (isset($lesFraisHorsForfait)&& $lesFraisHorsForfait!=array()) { ?>
            <caption>Eléments non forfaitisés </caption>
            <?php
            $totalFraisHorsForfait = 0;
            foreach ( $lesFraisHorsForfait as $unFraisHorsForfait )
            {
                $idFrais =  $unFraisHorsForfait['id'];

               $libelle = $unFraisHorsForfait['libelle'];
                   $montant = $unFraisHorsForfait['montant'];
                  $totalFraisHorsForfait +=$montant;

    ?>    <input type="hidden" name="idFraisHorsForfait" value="<?php echo $idFrais; ?>"></br> <button onclick="triggerButton('?uc=validerFrais&action=supprimerFraisHorsForfait&idFraisHorsForfait=<?php echo $idFrais; ?>'  ,'validationForm' );" type="button">Supprimer</button><?php


           ?>

   <i> <label for="<?php echo $idFrais; ?>" ><?php echo $libelle; ?></label>
   </i> <input id="<?php echo $idFrais; ?>" type="text" name="<?php echo $idFrais;?>" value="<?php echo $montant;?>"  'disabled'></br>

            <?php
        }     echo 'Montant total hors forfait:'.$totalFraisHorsForfait;

         if ($editableForm){?>
         </p>


   <?php     } }	?>
   <button onclick="triggerButton('?uc=validerFrais&action=mettreEnPaiement','validationForm' );" type="button">Mettre en paiement</button>

		</tr>


        </form>
    </div>
<script type="text/javascript">
function postOn(param_string, form_id){
    if(typeof options === "undefined") {
      form_ellement = document.getElementsByTagName("form")[0];
  }else {
      form_ellement = document.getElementById('form_id');
  }
            form_ellement.action=form_ellement.action+param_string;
        return form_ellement
}

function triggerButton(key, value, form_id){
     postOn(key, value, form_id).submit();
}
</script>
