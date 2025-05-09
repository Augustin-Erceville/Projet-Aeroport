<?php
session_start();

if (!isset($_SESSION['utilisateur'])) {
    $_SESSION['error'] = "Veuillez vous connecter pour réserver.";
    header("Location: ../../views/Connexion.php");
    exit();
}

require_once '../bdd/config.php';
require_once '../repository/ReservationsRepository.php';

$config = new Config();
$bdd = $config->connexion();
$resRepo = new ReservationsRepository($bdd);

$idUtilisateur = $_SESSION['utilisateur']['id'];
$idVol = isset($_GET['id_vol']) ? (int) $_GET['id_vol'] : 0;
$classe = $_GET['classe'] ?? 'Économique';

if ($idVol <= 0 || !in_array($classe, ['Économique', 'Affaires', 'Première'])) {
    $_SESSION['error'] = "Paramètres invalides.";
    header("Location: ../../views/AcheterBillet.php");
    exit();
}

$resRepo->creerReservationRapide($idUtilisateur, $idVol, $classe);
$_SESSION['success'] = "Votre réservation en $classe a bien été prise en compte.";
header("Location: ../../views/Reservation.php");
exit();
?>