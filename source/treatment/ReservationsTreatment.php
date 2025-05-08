<?php

require_once __DIR__ . '/../bdd/config.php';
require_once __DIR__ . '/../repository/ReservationsRepository.php';
require_once __DIR__ . '/../model/ReservationsModel.php';

$config = new Config();
$connexion = $config->connexion();
$reservationRepository = new ReservationsRepository($connexion);

if (isset($_POST['addReservation'])) {
    $newReservation = new ReservationsModel([
        'ref_utilisateur' => (int) $_POST['ref_utilisateur'],
        'ref_vol' => (int) $_POST['ref_vol'],
        'classe' => $_POST['classe'],
        'statut' => $_POST['statut'],
        'date_reservation' => $_POST['date_reservation']
    ]);

    $success = $reservationRepository->add($newReservation);

    header('Location: ../../views/Reservations/ReservationsRead.php?' . ($success ? 'success=add' : 'error=add'));
    exit();
}

if (isset($_POST['updateReservation'])) {
    $reservationToUpdate = new ReservationsModel([
        'id_reservation' => $_POST['id_reservation'],
        'ref_utilisateur' => (int) $_POST['ref_utilisateur'],
        'ref_vol' => (int) $_POST['ref_vol'],
        'classe' => $_POST['classe'],
        'statut' => $_POST['statut'],
        'date_reservation' => $_POST['date_reservation']
    ]);

    $success = $reservationRepository->update($reservationToUpdate);

    header('Location: ../../views/Reservations/ReservationsRead.php?' . ($success ? 'success=update' : 'error=update'));
    exit();
}

if (isset($_GET['deleteReservation'])) {
    $idReservation = (int) $_GET['deleteReservation'];

    $success = $reservationRepository->delete($idReservation);

    header('Location: ../../views/Reservations/ReservationsRead.php?' . ($success ? 'success=delete' : 'error=delete'));
    exit();
}
