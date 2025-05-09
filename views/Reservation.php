<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once '../source/bdd/config.php';
require_once '../source/repository/ReservationsRepository.php';

$config = new Config();
$bdd = $config->connexion();
$reservationRepo = new ReservationsRepository($bdd);

if (!isset($_SESSION['utilisateur'])) {
    $_SESSION['error'] = "Vous devez être connecté pour accéder à vos réservations.";
    header('Location: Connexion.php');
    exit;
}
$prenom = htmlspecialchars($_SESSION['utilisateur']['prenom']);
$idUser = $_SESSION['utilisateur']['id'];
$reservations = $reservationRepo->getReservationsByUserId($idUser);
?>
    <!doctype html>
    <html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>RESERVATION • AEROPORTAL</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
<body>
<header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom bg-dark">
    <div class="col-2 ms-3 mb-2 mb-md-0 text-light">
        <a href="Acceuil.php" class="d-inline-flex link-body-emphasis text-decoration-none">
            <img src="../documentation/img/Logo.png" style="max-width: 15%; height: auto;">
            <div class="fs-4 text-light">AEROPORTAL</div>
        </a>
    </div>

    <ul class="nav col mb-2 justify-content-center mb-md-0">
        <li><a href="Acceuil.php" class="nav-link px-2"><button type="button" class="btn btn-outline-info">Accueil</button></a></li>
        <li><a href="AcheterBillet.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Acheter un billet</button></a></li>
        <li><a href="Enregistrement.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Enregistrement</button></a></li>
        <li><a href="Reservation.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light active">Mes reservations</button></a></li>
        <li><a href="Information.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Informations</button></a></li>
        <li><a href="Aide.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Aide</button></a></li>
        <?php if (isset($_SESSION['utilisateur']) && $_SESSION['utilisateur']['role'] === 'Administrateur'): ?>
            <li><a href="Administration.php" class="nav-link px-2"><button type="button" class="btn btn-outline-warning">Administration</button></a></li>
        <?php endif; ?>
    </ul>

    <div class="col-2 btn-group md-3 me-3 text-end" role="group" aria-label="Boutons utilisateur">
        <?php if (isset($_SESSION['utilisateur'])): ?>
            <a href="../views/Account/AccountView.php" class="btn btn-outline-primary">MON COMPTE</a>
            <a href="../source/treatment/deconnexion.php" class="btn btn-outline-danger">DÉCONNEXION</a>
        <?php else: ?>
            <a href="Connexion.php" class="btn btn-outline-success">CONNEXION</a>
            <a href="Inscription.php" class="btn btn-outline-primary">INSCRIPTION</a>
        <?php endif; ?>
    </div>
</header>
<div class="mx-4">
    <div class="row">
        <h4 class="text-center text-uppercase">Vos reservations</h4>
    </div>
</div>
<div class="container mt-5">
    <h1 class="text-center text-primary mb-4">Mes réservations</h1>

    <?php if (empty($reservations)): ?>
        <div class="alert alert-info text-center">
            Vous n'avez encore effectué aucune réservation.
        </div>
        <div class="text-center">
            <a href="AcheterBillet.php" class="btn btn-outline-primary">Réserver un vol</a>
        </div>
    <?php else: ?>
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
            <tr>
                <th>#</th>
                <th>Vol</th>
                <th>Destination</th>
                <th>Date de départ</th>
                <th>Statut</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($reservations as $index => $res): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($res->getRefVol()) ?></td>
                    <td><?= htmlspecialchars($res->getDestination()) ?></td>
                    <td><?= htmlspecialchars($res->getDateDepart()) ?></td>
                    <td>
                        <?php if ($res->getStatut() === 'Confirmée'): ?>
                            <span class="badge bg-success">Confirmée</span>
                        <?php elseif ($res->getStatut() === 'Annulée'): ?>
                            <span class="badge bg-danger">Annulée</span>
                        <?php else: ?>
                            <span class="badge bg-secondary"><?= htmlspecialchars($res->getStatut()) ?></span>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
<?php include 'Footer.php'; ?>