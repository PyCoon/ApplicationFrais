<?php
if (isset($simpleMessage)){
    echo $simpleMessage;

    ?>

<p>
<h2>Récapitulatif</h2>
    <?php
    $totalFrais = 0;
    foreach ($lesFrais as $key => $value) {
        $libelle = $dictFraisForfaits[$key][0];
        $montant = $dictFraisForfaits[$key][1];
        $total = $value * $montant;
        $totalFrais+=$total
        ?>
        Récap:
        <?php echo $libelle; ?>: <?php echo $value; ?> * <?php echo $montant; ?> soit <strong><?php echo $total; ?> euros </strong></br>



        <?php
    }
    ?>
    </p>
    <p>

    <strong>Valider la fiche d'un montant de <?php echo $totalFrais; ?> euros. </strong></br>
    </p>
    <form action="index.php?uc=validerFrais&action=mettreEnPaiement" method="POST">
        <input type="hidden" name="idDuVisiteurSelectionne" value="<?php echo $idDuVisiteurSelectionne; ?>">
        <input type="hidden" name='moisSelectionne' value="<?php echo $moisSelectionne; ?>">
        <input type="submit">
    </form>
    <?php

}elseif (isset($_REQUEST['erreurs'])) {
    echo $_REQUEST['erreurs'];

}
?>
