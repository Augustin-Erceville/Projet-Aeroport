<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once '../source/bdd/config.php';
require_once '../source/model/VolsModel.php';
require_once '../source/repository/VolsRepository.php';
$config = new Config();
$bdd = $config->connexion();
$volRepo = new VolsRepository($bdd);

$prochainsVols = $volRepo->getNextFiveVols();
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ACCUEIL • AEROPORTAL</title>
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
        <li><a href="Acceuil.php" class="nav-link px-2"><button type="button" class="btn btn-outline-info active">Accueil</button></a></li>
        <li><a href="AcheterBillet.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Acheter un billet</button></a></li>
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
    <h1 class="text-center text-primary mb-4">Bienvenue sur Aéroportal</h1>

    <div class="row justify-content-center mb-5">
        <div class="col-md-8 text-center">
            <p class="lead">
                Aéroportal est votre plateforme centrale pour gérer tous les aspects liés à l'aéroport :
                vols, réservations, compagnies aériennes, pilotes, enregistrements, et bien plus encore.
            </p>
            <p>
                Que vous soyez un passager souhaitant réserver un billet ou un administrateur en charge des opérations aériennes,
                notre interface simplifiée et intuitive est là pour vous accompagner.
            </p>
        </div>
    </div>

    <div class="row g-4 text-center">
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">🛩️ Réservez un vol</h5>
                    <p class="card-text">Trouvez et réservez un billet en quelques clics, selon vos préférences de date et destination.</p>
                    <a href="AcheterBillet.php" class="btn btn-outline-primary">Acheter un billet</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">📋 Suivi de réservation</h5>
                    <p class="card-text">Consultez, modifiez ou annulez vos réservations existantes facilement depuis votre espace.</p>
                    <a href="Reservation.php" class="btn btn-outline-primary">Mes réservations</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <h5 class="card-title">ℹ️ Informations générales</h5>
                    <p class="card-text">Retrouvez toutes les informations utiles : horaires, consignes, assistance et règlement.</p>
                    <a href="Information.php" class="btn btn-outline-primary">En savoir plus</a>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <h2 class="text-center text-info my-3">Prochains départs</h2>

        <?php if (!empty($prochainsVols)): ?>
            <?php foreach ($prochainsVols as $vol): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($vol->getNumeroVol()) ?></h5>
                            <p class="card-text">
                                <strong>Destination :</strong> <?= htmlspecialchars($vol->getAeroportArrivee()) ?><br>
                                <strong>Départ :</strong> <?= htmlspecialchars($vol->getDateDepart()) ?><br>
                                <strong>Compagnie :</strong> <?= htmlspecialchars($vol->getNomCompagnie()) ?>
                            </p>
                            <a href="AcheterBillet.php" class="btn btn-primary">Réserver</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-muted">Aucun vol disponible pour le moment.</p>
        <?php endif; ?>
    </div>
    <div class="text-center mt-5">
        <?php if (!isset($_SESSION['utilisateur'])): ?>
            <a href="Connexion.php" class="btn btn-success btn-lg me-2">Se connecter</a>
            <a href="Inscription.php" class="btn btn-outline-secondary btn-lg">Créer un compte</a>
        <?php else: ?>
            <a href="../views/Account/AccountView.php" class="btn btn-outline-info btn-lg">Accéder à mon compte</a>
        <?php endif; ?>
    </div>
</div>

<?php include 'Footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoIIfJcLyjU29tka7Sk3YSA8l7IgGKmFckcImFV8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>
