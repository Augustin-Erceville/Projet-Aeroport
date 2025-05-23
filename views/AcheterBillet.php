<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once '../source/bdd/config.php';
require_once '../source/model/VolsModel.php';
require_once '../source/repository/VolsRepository.php';

$config = new Config();
$bdd = $config->connexion();
$volRepo = new VolsRepository($bdd);

$volsDisponibles = $volRepo->getAllVols();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>BILLETS • AEROPORTAL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>

<header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom bg-dark">
    <div class="col-2 ms-3 mb-2 mb-md-0 text-light">
         <a href="Acceuil.php" class="d-inline-flex link-body-emphasis text-decoration-none">
              <img src="../documentation/img/Logo.png" class="rounded-circle mx-3" style="max-width: 15%; height: auto;">
              <div class="fs-4 text-light">AEROPORTAL</div>
         </a>
    </div>

    <ul class="nav col mb-2 justify-content-center mb-md-0">
        <li><a href="Acceuil.php" class="nav-link px-2"><button type="button" class="btn btn-outline-info">Accueil</button></a></li>
        <li><a href="AcheterBillet.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light active">Acheter un billet</button></a></li>
        <li><a href="Enregistrement.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Enregistrement</button></a></li>
        <li><a href="Reservation.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Mes réservations</button></a></li>
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

<div class="container my-4">
    <div class="row">
        <h4 class="text-center text-uppercase mb-4">Où souhaitez-vous aller ?</h4>
    </div>

    <div class="row">
        <?php if (!empty($volsDisponibles)): ?>
            <?php foreach ($volsDisponibles as $vol): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($vol->getNumeroVol()) ?></h5>
                            <p class="card-text">
                                <strong>Départ :</strong> <?= htmlspecialchars($vol->getAeroportDepart()) ?><br>
                                <strong>Arrivée :</strong> <?= htmlspecialchars($vol->getAeroportArrivee()) ?><br>
                                <strong>Date de départ :</strong> <?= htmlspecialchars($vol->getDateDepart()) ?><br>
                                <strong>Prix :</strong> <?= htmlspecialchars(number_format($vol->getPrix(), 2)) ?> €
                            </p>
                            <form action="../source/treatment/ReservationRapide.php" method="get">
                                <input type="hidden" name="id_vol" value="<?= $vol->getIdVol() ?>">

                                <div class="mb-2">
                                    <select name="classe" class="form-select form-select-sm" required>
                                        <option value="Économique">Classe Économique</option>
                                        <option value="Affaires">Classe Affaires</option>
                                        <option value="Première">Classe Première</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary w-100">Réserver</button>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-muted">Aucun vol disponible pour le moment.</p>
        <?php endif; ?>
    </div>
</div>


<?php include 'Footer.php'; ?>