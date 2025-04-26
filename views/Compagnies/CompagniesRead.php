<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../../source/bdd/config.php';
require_once __DIR__ . '/../../source/repository/CompagniesRepository.php';
require_once __DIR__ . '/../../source/model/CompagniesModel.php';

$config = new Config();
$bdd = $config->connexion();
$compagniesRepo = new CompagniesRepository($bdd);
$compagnies = $compagniesRepo->getCompagnies();
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AEROPORTAL – Gestion des compagnies</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<header class="d-flex flex-wrap align-items-center justify-content-between py-3 mb-4 border-bottom bg-dark">
    <div class="col-2 ms-3 text-light">
        <a href="../Acceuil.php" class="d-inline-flex text-decoration-none">
            <img src="../../documentation/img/Logo.png" style="max-width: 15%; height: auto;">
            <div class="fs-4 text-light">AEROPORTAL</div>
        </a>
    </div>
    <ul class="nav col mb-2 justify-content-center">
        <li><a href="../Acceuil.php" class="nav-link px-2"><button class="btn btn-outline-info">Accueil</button></a></li>
        <li><a href="../Avions/AvionsRead.php" class="nav-link px-2"><button class="btn btn-outline-light">Gestion avions</button></a></li>
        <li><a href="../Compagnies/CompagniesRead.php" class="nav-link px-2"><button class="btn btn-outline-light">Gestion compagnies</button></a></li>
        <li><a href="../Conges/CongesRead.php" class="nav-link px-2"><button class="btn btn-outline-light">Gestion congés</button></a></li>
        <li><a href="../Pilotes/PilotesRead.php" class="nav-link px-2"><button class="btn btn-outline-light">Gestion pilotes</button></a></li>
        <li><a href="../Reservations/ReservationsRead.php" class="nav-link px-2"><button class="btn btn-outline-light">Gestion réservations</button></a></li>
        <li><a href="../Utilisateurs/UtilisateursRead.php" class="nav-link px-2"><button class="btn btn-outline-light">Gestion utilisateurs</button></a></li>
        <li><a href="../Vols/VolsRead.php" class="nav-link px-2"><button class="btn btn-outline-light">Gestion vols</button></a></li>
    </ul>
    <div class="col-2 me-3 text-end">
        <?php if (isset($_SESSION['utilisateur'])): ?>
            <a href="../../source/treatment/deconnexion.php" class="btn btn-outline-danger">DÉCONNEXION</a>
        <?php else: ?>
            <a href="../Connexion.php" class="btn btn-outline-success">CONNEXION</a>
            <a href="../Inscription.php" class="btn btn-outline-primary">INSCRIPTION</a>
        <?php endif; ?>
    </div>
</header>

<div class="container mt-5">
    <h4 class="text-center text-uppercase">Liste des vols</h4>
    <a href="VolsCreate.php" class="btn btn-success mb-4 d-grid gap-2" style="text-transform: uppercase">Ajouter un vol</a>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Pays d’origine</th>
            <th>Date de création</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($compagnies as $compagnie): ?>
            <tr>
                <td><?= htmlspecialchars($compagnie->getId(), ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($compagnie->getNom(), ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($compagnie->getPays(), ENT_QUOTES, 'UTF-8') ?></td>
                <td><?= htmlspecialchars($compagnie->getDateCreation(), ENT_QUOTES, 'UTF-8') ?></td>
                <td>
                    <a href="CompagniesUpdate.php?id=<?= $compagnie->getId() ?>" class="btn btn-warning btn-sm">✒️</a>
                    <a href="CompagniesDelete.php?id=<?= $compagnie->getId() ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Voulez-vous vraiment supprimer cette compagnie ?');">
                        🗑️
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include '../Footer.php'; ?>
</body>
</html>
