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

<div class="container mt-5">
     <h2 class="text-center mb-4">Liste des vols</h2>

     <?php if (isset($_SESSION['success'])): ?>
          <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
          <?php unset($_SESSION['success']); ?>
     <?php endif; ?>

     <?php if (isset($_SESSION['error'])): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
          <?php unset($_SESSION['error']); ?>
     <?php endif; ?>

     <div class="mb-3 text-center">
          <a href="VolsCreate.php" class="btn btn-success">Ajouter un vol</a>
     </div>

     <div class="table-responsive">
          <table class="table table-striped table-hover">
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
                              <td><?= htmlspecialchars($vol['ID']) ?></td>
                              <td><?= htmlspecialchars($vol['Numéro Vol']) ?></td>
                              <td><?= htmlspecialchars($vol['Compagnie']) ?></td>
                              <td><?= htmlspecialchars($vol['Avion']) ?></td>
                              <td><?= htmlspecialchars($vol['Aéroport Départ']) ?></td>
                              <td><?= htmlspecialchars($vol['Aéroport Arrivée']) ?></td>
                              <td><?= htmlspecialchars($vol['Date Départ']) ?></td>
                              <td><?= htmlspecialchars($vol['Date Arrivée']) ?></td>
                              <td><?= htmlspecialchars(number_format($vol['Prix'], 2, ',', ' ')) ?> €</td>
                              <td><?= htmlspecialchars($vol['Statut']) ?></td>
                              <td>
                                   <a href="VolsUpdate.php?id=<?= $vol['ID'] ?>" class="btn btn-warning btn-sm">✏️</a>
                                   <a href="VolsDelete.php?id=<?= $vol['ID'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce vol ?');">🗑️</a>
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
     </div>
</div>
<?php include '../Footer.php'; ?>