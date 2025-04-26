<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../../source/bdd/config.php';
require_once __DIR__ . '/../../source/model/AvionsModel.php';
require_once __DIR__ . '/../../source/repository/AvionsRepository.php';

$config         = new Config();
$bdd            = $config->connexion();
$avionRepo      = new AvionsRepository($bdd);

$avions = [];
try {
    $stmt = $bdd->query("SELECT * FROM avions");
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $avion = new AvionModel();
        $avion->hydrate($row);
        $avions[] = $avion;
    }
} catch (PDOException $e) {
    die("Erreur lors de la récupération des avions : " . $e->getMessage());
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AEROPORTAL - GESTION AVIONS</title>
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
        <li><a href="../Acceuil.php" class="nav-link px-2"><button type="button" class="btn btn-outline-info">Acceuil</button></a></li>
        <li><a href="../Avions/AvionsRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light active">Gestion avions</button></a></li>
        <li><a href="../Compagnies/CompagniesRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion compagnies</button></a></li>
        <li><a href="../Conges/CongesRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion congés</button></a></li>
        <li><a href="../Pilotes/PilotesRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion pilotes</button></a></li>
        <li><a href="../Reservations/ReservationsRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion reservations</button></a></li>
        <li><a href="../Utilisateurs/UtilisateursRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion utilisateurs</button></a></li>
        <li><a href="../Vols/VolsRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light active">Gestion vols</button></a></li>
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
        <h4 class="text-center text-uppercase">Liste des avions</h4>
        <a href="AvionsCreate.php" class="btn btn-outline-success text-uppercase">Ajouter un avion</a>
    </div>
</div>
<div class="row my-3">
    <div class="col-1"></div>
    <table class="col table table-striped">
    <thead>
    <tr>
        <th>ID</th>
        <th>Nom</th>
        <th>Type</th>
        <th>Capacité</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php if (count($avions) > 0) : ?>
        <?php foreach ($avions as $avion) : ?>
            <tr>
                <td><?= htmlspecialchars($avion->getId()) ?></td>
                <td><?= htmlspecialchars($avion->getNom()) ?></td>
                <td><?= htmlspecialchars($avion->getType()) ?></td>
                <td><?= htmlspecialchars($avion->getCapacite()) ?></td>
                <td>
                    <a href="AvionsUpdate.php?id=<?= $avion->getId() ?>">Modifier</a> |
                    <a href="AvionsDelete.php?id=<?= $avion->getId() ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet avion ?')">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else : ?>
        <tr>
            <td colspan="5">Aucun avion trouvé.</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>
    <div class="col-1"></div>
</div>

<?php include '../Footer.php'; ?>