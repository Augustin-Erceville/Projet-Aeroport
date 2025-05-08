<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../../source/bdd/config.php';
require_once __DIR__ . '/../../source/repository/ReservationsRepository.php';

$config = new Config();
$connexion = $config->connexion();

$reservationRepository = new ReservationsRepository($connexion);
$reservations = $reservationRepository->getAll();
?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Liste des Pilotes</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    </head>
<body>
<header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom bg-dark">
    <div class="col-2 ms-3 mb-2 mb-md-0 text-light">
        <a href="../Acceuil.php" class="d-inline-flex link-body-emphasis text-decoration-none">
            <img src="../../documentation/img/Logo.png" style="max-width: 15%; height: auto;">
            <div class="fs-4 text-light">AEROPORTAL</div>
        </a>
    </div>
    <ul class="nav col mb-2 justify-content-center mb-md-0">
        <li><a href="../Acceuil.php" class="nav-link px-2"><button type="button" class="btn btn-outline-info">Accueil</button></a></li>
        <li><a href="../Avions/AvionsRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion avions</button></a></li>
        <li><a href="../Compagnies/CompagniesRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion compagnies</button></a></li>
        <li><a href="../Conges/CongesRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion congés</button></a></li>
        <li><a href="../Pilotes/PilotesRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion pilotes</button></a></li>
        <li><a href="../Reservations/ReservationsRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light active">Gestion réservations</button></a></li>
        <li><a href="../Utilisateurs/UtilisateursRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion utilisateurs</button></a></li>
        <li><a href="../Vols/VolsRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion vols</button></a></li>
    </ul>

    <div class="col-2 btn-group md-3 me-3 text-end" role="group" aria-label="Boutons utilisateur">
        <?php if (isset($_SESSION['utilisateur'])): ?>
            <a href="../../source/treatment/deconnexion.php" class="btn btn-outline-danger">DÉCONNEXION</a>
        <?php else: ?>
            <a href="Connexion.php" class="btn btn-outline-success">CONNEXION</a>
            <a href="Inscription.php" class="btn btn-outline-primary">INSCRIPTION</a>
        <?php endif; ?>
    </div>
</header>

<div class="mx-4">
    <div class="row">
        <h4 class="text-center text-uppercase">Liste des reservations</h4>
        <a href="ReservationsCreate.php" class="btn btn-outline-success text-uppercase">Ajouter une reservation</a>
    </div>
</div>

<div class="row my-3">
    <div class="col-1"></div>
    <table class="col table table-striped">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Utilisateur</th>
            <th>Vol</th>
            <th>Classe</th>
            <th>Statut</th>
            <th>Date</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php if (count($reservations) > 0): ?>
            <?php foreach ($reservations as $reservation): ?>
                <tr>
                    <td><?= htmlspecialchars($reservation['ID']) ?></td>
                    <td><?= htmlspecialchars($reservation['Utilisateur']) ?></td>
                    <td><?= htmlspecialchars($reservation['Vol']) ?></td>
                    <td><?= htmlspecialchars($reservation['Classe']) ?></td>
                    <td><?= htmlspecialchars($reservation['Statut']) ?></td>
                    <td><?= htmlspecialchars($reservation['Date']) ?></td>
                    <td>
                        <a href="ReservationsUpdate.php?id=<?= htmlspecialchars($reservation['ID']) ?>" class="btn btn-warning btn-sm">✏️</a>
                        <a href="../../source/treatment/ReservationsTreatment.php?deleteReservation=<?= htmlspecialchars($reservation['ID']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette réservation ?');">🗑️</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="5" class="text-center">Aucun pilote trouvé.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
    <div class="col-1"></div>
</div>

<?php include '../Footer.php'; ?>