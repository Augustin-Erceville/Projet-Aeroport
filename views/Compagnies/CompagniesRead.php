<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../../source/repository/CompagniesRepository.php';
require_once __DIR__ . '/../../source/bdd/config.php';
require_once __DIR__ . '/../../source/model/CompagniesModel.php';

$config = new Config();
$bdd = $config->connexion();
$compagnieRepo = new CompagniesRepository($bdd);
$compagnies = $compagnieRepo->getCompagnies();
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AEROPORTAL - GESTION DES COMPAGNIES</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
        <li><a href="../Acceuil.php" class="nav-link px-2"><button type="button" class="btn btn-outline-info">Acceuil</button></a></li>
        <li><a href="../Avions/AvionsRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light active">Gestion avions</button></a></li>
        <li><a href="../Compagnies/CompagniesRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion compagnies</button></a></li>
        <li><a href="../Conges/CongesRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion congés</button></a></li>
        <li><a href="../Pilotes/PilotesRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion pilotes</button></a></li>
        <li><a href="../Reservations/ReservationsRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion réservations</button></a></li>
        <li><a href="../Utilisateurs/UtilisateursRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion utilisateurs</button></a></li>
        <li><a href="../Vols/VolsRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion vols</button></a></li>
    </ul>
    <div class="col-2 btn-group md-3 me-3 text-end" role="group" aria-label="Boutons utilisateur">
        <?php if (isset($_SESSION['utilisateur'])): ?>
            <a href="../../views/Account/AccountView.php" class="btn btn-outline-primary">MON COMPTE</a>
            <a href="../source/treatment/deconnexion.php" class="btn btn-outline-danger">DÉCONNEXION</a>
        <?php else: ?>
            <a href="Connexion.php" class="btn btn-outline-success">CONNEXION</a>
            <a href="Inscription.php" class="btn btn-outline-primary">INSCRIPTION</a>
        <?php endif; ?>
    </div>
</header>

<div class="mx-4">
    <div class="row">
        <h4 class="text-center text-uppercase">Liste des compagnies</h4>
        <a href="CompagniesCreate.php" class="btn btn-outline-success text-uppercase">Ajouter une compagnie</a>
    </div>
</div>

<div class="row my-3">
    <div class="col-1"></div>
    <table class="col table table-striped">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Pays</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($compagnies as $compagnie): ?>
            <tr>
                <td><?= htmlspecialchars($compagnie->getIdCompagnie() ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($compagnie->getNom() ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($compagnie->getPays() ?? '', ENT_QUOTES, 'UTF-8') ?></td>
                <td>
                    <a href="CompagniesUpdate.php?id=<?= $compagnie->getIdCompagnie() ?>" class="btn btn-warning btn-sm">✒️</a>
                    <a href="CompagniesDelete.php?id=<?= $compagnie->getIdCompagnie() ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette compagnie ?');">🗑️</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="col-1"></div>
</div>
<?php include '../Footer.php'; ?>