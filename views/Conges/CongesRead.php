<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once '../../source/bdd/config.php';
require_once '../../source/repository/CongesRepository.php';

$config = new Config();
$bdd = $config->connexion();
$congeRepo = new CongesRepository($bdd);

try {
    $conges = $congeRepo->getConges();
} catch (PDOException $e) {
    die("Erreur lors de la récupération des congés : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des Congés</title>
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
        <h4 class="text-center text-uppercase">Liste des congés</h4>
        <a href="CongesCreate.php" class="btn btn-outline-success text-uppercase">Ajouter un congé</a>
    </div>
</div>

<div class="row my-3">
    <div class="col-1"></div>
    <table class="col table table-striped">
        <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Pilote</th>
            <th>Date début</th>
            <th>Date fin</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($conges as $conge): ?>
            <tr>
                <td><?= htmlspecialchars($conge['ID'] ?? '') ?></td>
                <td><?= htmlspecialchars($conge['Pilote'] ?? '') ?></td>
                <td><?= htmlspecialchars($conge['Date Début'] ?? '') ?></td>
                <td><?= htmlspecialchars($conge['Date Fin'] ?? '') ?></td>
                <td>
                    <a href="CongesUpdate.php?id=<?= $conge['ID'] ?>" class="btn btn-warning btn-sm">✏️</a>
                    <a href="../../source/treatment/CongesTreatment.php?action=delete&id=<?= $conge['ID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Supprimer ce congé ?')">🗑️</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <div class="col-1"></div>
</div>

<?php include '../Footer.php'; ?>
</body>
</html>
