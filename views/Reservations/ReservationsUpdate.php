<?php
require_once __DIR__ . '/../../source/bdd/config.php';
require_once __DIR__ . '/../../source/repository/ReservationsRepository.php';
require_once __DIR__ . '/../../source/repository/UtilisateursRepository.php';
require_once __DIR__ . '/../../source/repository/VolsRepository.php';

$config = new Config();
$connexion = $config->connexion();

$reservationRepository = new ReservationsRepository($connexion);
$utilisateurRepository = new UtilisateursRepository($connexion);
$volRepository = new VolsRepository($connexion);

if (!isset($_GET['id'])) {
    header('Location: ReservationsRead.php');
    exit();
}

$id = (int)$_GET['id'];
$reservation = $reservationRepository->getById($id);

if (!$reservation) {
    header('Location: ReservationsRead.php');
    exit();
}

$utilisateurs = $utilisateurRepository->getUsers();
$vols = $volRepository->getVols();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier une Réservation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center mb-4">Modifier une Réservation</h2>

    <form action="../../source/treatment/ReservationsTreatment.php" method="post">
        <input type="hidden" name="id_reservation" value="<?= htmlspecialchars($reservation->getId_reservation()) ?>">

        <div class="mb-3">
            <label for="ref_utilisateur" class="form-label">Utilisateur</label>
            <select class="form-select" name="ref_utilisateur" id="ref_utilisateur" required>
                <?php foreach ($utilisateurs as $utilisateur): ?>
                    <option value="<?= htmlspecialchars($utilisateur->getIdUser()) ?>"
                        <?= $utilisateur->getIdUser() == $reservation->getRef_utilisateur() ? 'selected' : '' ?>>
                        <?= htmlspecialchars($utilisateur->getPrenom() . ' ' . $utilisateur->getNom()) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="ref_vol" class="form-label">Vol</label>
            <select class="form-select" name="ref_vol" id="ref_vol" required>
                <?php foreach ($vols as $vol): ?>
                    <option value="<?= htmlspecialchars($vol['id_vol']) ?>"
                        <?= $vol['id_vol'] == $reservation->getRef_vol() ? 'selected' : '' ?>>
                        <?= htmlspecialchars($vol['numero_vol']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="classe" class="form-label">Classe</label>
            <select class="form-select" name="classe" id="classe" required>
                <option value="Économique" <?= $reservation->getClasse() == 'Économique' ? 'selected' : '' ?>>Économique</option>
                <option value="Affaires" <?= $reservation->getClasse() == 'Affaires' ? 'selected' : '' ?>>Affaires</option>
                <option value="Première" <?= $reservation->getClasse() == 'Première' ? 'selected' : '' ?>>Première</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="statut" class="form-label">Statut</label>
            <select class="form-select" name="statut" id="statut" required>
                <option value="confirmé" <?= $reservation->getStatut() == 'confirmé' ? 'selected' : '' ?>>Confirmé</option>
                <option value="annulé" <?= $reservation->getStatut() == 'annulé' ? 'selected' : '' ?>>Annulé</option>
                <option value="en attente" <?= $reservation->getStatut() == 'en attente' ? 'selected' : '' ?>>En attente</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="date_reservation" class="form-label">Date de réservation</label>
            <input type="datetime-local" class="form-control" name="date_reservation" id="date_reservation"
                   value="<?= htmlspecialchars(date('Y-m-d\TH:i', strtotime($reservation->getDate_reservation()))) ?>" required>
        </div>

        <button type="submit" name="updateReservation" class="btn btn-primary">Modifier</button>
        <a href="ReservationsRead.php" class="btn btn-secondary">Retour</a>
    </form>
</div>
<?php include '../Footer.php'; ?>
