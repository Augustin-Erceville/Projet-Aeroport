<?php
require_once __DIR__ . '/../../source/bdd/config.php';
require_once __DIR__ . '/../../source/repository/ReservationsRepository.php';

if (!isset($_GET['id'])) {
    header('Location: ReservationsRead.php');
    exit();
}

$config = new Config();
$connexion = $config->connexion();
$reservationRepository = new ReservationsRepository($connexion);

$id = (int)$_GET['id'];

$reservation = $reservationRepository->getById($id);

if (!$reservation) {
    header('Location: ReservationsRead.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $success = $reservationRepository->delete($id);

    if ($success) {
        header('Location: ReservationsRead.php?success=delete');
    } else {
        header('Location: ReservationsRead.php?error=delete');
    }
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Supprimer une Réservation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Supprimer la Réservation</h2>

    <div class="alert alert-warning text-center">
        Voulez-vous vraiment supprimer la réservation <strong>#<?= htmlspecialchars($reservation->getId_reservation()) ?></strong> ?
    </div>

    <form method="post" class="text-center">
        <button type="submit" class="btn btn-danger">Confirmer la suppression</button>
        <a href="ReservationsRead.php" class="btn btn-secondary">Annuler</a>
    </form>
</div>
<?php include '../Footer.php'; ?>