<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once '../../source/bdd/config.php';
require_once '../../source/repository/VolsRepository.php';

$config = new Config();
$bdd = $config->connexion();
$volRepo = new VolsRepository($bdd);

try {
     $vols = $volRepo->getVols();
} catch (PDOException $e) {
     die("Erreur lors de la récupération des vols : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
     <meta charset="UTF-8">
     <title>Liste des Vols</title>
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
          <li><a href="../Reservations/ReservationsRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion réservations</button></a></li>
          <li><a href="../Utilisateurs/UtilisateursRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion utilisateurs</button></a></li>
          <li><a href="../Vols/VolsRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light active">Gestion vols</button></a></li>
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
          <h4 class="text-center text-uppercase">Liste des vols</h4>
          <a href="VolsCreate.php" class="btn btn-outline-success text-uppercase">Ajouter un vol</a>
     </div>
</div>

<div class="row my-3">
     <div class="col-1"></div>
     <table class="col table table-striped">
          <thead class="table-dark">
          <tr>
               <th>ID</th>
               <th>Numéro Vol</th>
               <th>Compagnie</th>
               <th>Avion</th>
               <th>Aéroport Départ</th>
               <th>Aéroport Arrivée</th>
               <th>Date Départ</th>
               <th>Date Arrivée</th>
               <th>Prix (€)</th>
               <th>Statut</th>
               <th>Actions</th>
          </tr>
          </thead>
          <tbody>
          <?php if (count($vols) > 0): ?>
              <?php foreach ($vols as $vol): ?>
                  <tr>
                      <td><?= htmlspecialchars($vol['ID'] ?? '') ?></td>
                      <td><?= htmlspecialchars($vol['Numéro vol'] ?? '') ?></td>
                      <td><?= htmlspecialchars($vol['Compagnie'] ?? '') ?></td>
                      <td><?= htmlspecialchars($vol['Avion'] ?? '') ?></td>
                      <td><?= htmlspecialchars($vol['Aéroport départ'] ?? '') ?></td>
                      <td><?= htmlspecialchars($vol['Aéroport arrivée'] ?? '') ?></td>
                      <td><?= htmlspecialchars($vol['Date départ'] ?? '') ?></td>
                      <td><?= htmlspecialchars($vol['Date arrivée'] ?? '') ?></td>
                      <td><?= htmlspecialchars(number_format($vol['Prix'] ?? 0, 2, ',', ' ')) ?> €</td>
                      <td><?= htmlspecialchars($vol['Statut'] ?? '') ?></td>
                      <td>
                          <a href="VolsUpdate.php?id=<?= htmlspecialchars($vol['ID'] ?? '') ?>" class="btn btn-warning btn-sm">✏️</a>
                          <a href="VolsDelete.php?id=<?= htmlspecialchars($vol['ID'] ?? '') ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce vol ?');">🗑️</a>
                      </td>
                  </tr>
              <?php endforeach; ?>
          <?php else: ?>
               <tr>
                    <td colspan="11" class="text-center">Aucun vol trouvé.</td>
               </tr>
          <?php endif; ?>
          </tbody>
     </table>
     <div class="col-1"></div>
</div>

<?php include '../Footer.php'; ?>