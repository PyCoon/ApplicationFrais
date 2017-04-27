<?php
require_once("../config.php")
require_once("include/fct.inc.php");
if($_SESSION['idTypeCompte'] != 2){
    header('Location : index.php');
    exit(0);
}

$arrayVisiteur = $pdo->getArrayVisiteur();
if(!isset($_GET['action'])){
    // Par défaut, on envoi l'utilisateur vers la selection des visiteurs.
    $_GET['action'] = 'selection';
}

include('vues/v_sommaire.php');
$action = $_GET['action'];

switch ($action) {
    case 'selection':   // Selection du visiteur et du mois
    if(isset($_POST['idDuVisiteurSelectionne'])){
        $leVisiteurSelectionne = $pdo->getInfosVisiteurParId($_POST['idDuVisiteurSelectionne']);
        $leVisiteurSelectionneId = $_POST['idDuVisiteurSelectionne'];
        // Les mois disponnibles avec le statu associé
        $moisDispo = $pdo->getLesMoisDisponiblesAvecEtat($_POST['idDuVisiteurSelectionne']);
    }

    else{
        $lesVisiteurs = $pdo->getArrayVisiteur();
    }
    include('vues/v_listeVisiteurs.php');

        break;

    // Génération de la page principale de validation
    case 'validerFicheFrais':

        $erreurs = "";
        $visiteurSelectionne = $pdo->getInfosVisiteurParId($_POST['idDuVisiteurSelectionne'])[0];
        $moisSelectionne = $_POST['moisSelectionne'];
        $annee =substr( $moisSelectionne,0,4);
        $mois =substr( $moisSelectionne,4,2);
        $infosFiche =  $pdo->getLesInfosFicheFrais($visiteurSelectionne['id'], $moisSelectionne);
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($visiteurSelectionne['id'],$moisSelectionne);
        $lesFraisForfait= $pdo->getLesFraisForfait($visiteurSelectionne['id'],$moisSelectionne);
        $lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($visiteurSelectionne['id'],$moisSelectionne);
        include('vues/v_validerFicheFrais.php');
        break;

    // modifier les frais, renvoie vers une autre page qui incite à la validation
    case 'modifierFraisForfait':

        $idDuVisiteurSelectionne=$_POST["idDuVisiteurSelectionne"];
        $moisSelectionne = $_POST['moisSelectionne'];
        $lesFrais = $_REQUEST['lesFrais'];
        if(lesQteFraisValides($lesFrais)){
            $pdo->majFraisForfait($idDuVisiteurSelectionne,$moisSelectionne,$lesFrais);
            $visiteurChaine=$pdo->getInfosVisiteurParId($idDuVisiteurSelectionne);
            $dictFraisForfaits = $pdo->getFraisforfaitsLibelles();
            $simpleMessage= "La fiche de ".$visiteurChaine[0][1]." ".$visiteurChaine[0][2]." a été mise à jour avec succès.";
            include("vues/v_fraisRecap.php");
        }
        else{
            ajouterErreur("Les valeurs des frais doivent être numériques");
            include("vues/v_erreurs.php");
        }
    $pdo->majFraisForfait($idDuVisiteurSelectionne, $moisSelectionne, $lesFrais);
    continue;

    // page Modif FHF
    case 'supprimerFraisHorsForfait':

         $pdo->supprimerFraisHorsForfait($_GET['idFraisHorsForfait']);
         $simpleMessage= "La fiche hors forfait de ".$visiteurChaine[0][1]." ".$visiteurChaine[0][2]." a été mise à été <strong>supprimée</strong>.";

         include("vues/v_fraisRecap.php");
        break;

    // page Modif FF
    case 'mettreEnPaiement':

        $idDuVisiteurSelectionne=$_POST["idDuVisiteurSelectionne"];
        $moisSelectionne = $_POST['moisSelectionne'];
        $pdo->majEtatFicheFrais($idDuVisiteurSelectionne,$moisSelectionne,'VA');
        // Redirection vers la page de selection
        header('Location: '.$URL_ROOT.'index.php?uc=validerFrais&action=selection');
        exit();
        break;

    default:

        break;
}
