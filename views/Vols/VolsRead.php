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
<?php include '../Header.php'; ?>

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