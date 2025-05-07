<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once '../../source/bdd/config.php';
require_once '../../source/repository/PilotesRepository.php';
require_once '../../source/repository/UtilisateursRepository.php';
require_once '../../source/repository/AvionsRepository.php';

$config = new Config();
$bdd = $config->connexion();

$piloteRepo = new PilotesRepository($bdd);
$utilisateurRepo = new UtilisateursRepository($bdd);
$avionRepo = new AvionsRepository($bdd);
$id = $_GET['id'] ?? null;
if (!$id) {
     $_SESSION['error'] = "Identifiant du pilote non fourni.";
     header('Location: PilotesRead.php');
     exit();
}

$pilote = $piloteRepo->getPiloteById((int) $id);

if (!$pilote) {
     $_SESSION['error'] = "Pilote non trouvé.";
     header('Location: PilotesRead.php');
     exit();
}

$utilisateurs = $utilisateurRepo->getUtilisateurs();
$avions = $avionRepo->getAvions();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
     <meta charset="UTF-8">
     <title>Modifier un Pilote</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
     <h2 class="text-center mb-4">Modifier le pilote</h2>

     <?php if (isset($_SESSION['error'])): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
          <?php unset($_SESSION['error']); ?>
     <?php endif; ?>

     <form method="post" action="../../source/treatment/PilotesTreatment.php">
          <input type="hidden" name="action" value="update">
          <input type="hidden" name="id_pilote" value="<?= htmlspecialchars($pilote->getIdPilote()) ?>">

          <div class="mb-3">
               <label for="ref_utilisateur" class="form-label">Utilisateur associé</label>
               <select class="form-select" id="ref_utilisateur" name="ref_utilisateur" required>
                    <option value="">-- Sélectionner un utilisateur --</option>
                    <?php foreach ($utilisateurs as $utilisateur): ?>
                         <option value="<?= htmlspecialchars($utilisateur->getIdUtilisateur()) ?>"
                              <?= $pilote->getRefUtilisateur() == $utilisateur->getIdUtilisateur() ? 'selected' : '' ?>>
                              <?= htmlspecialchars($utilisateur->getPrenom() . ' ' . $utilisateur->getNom()) ?>
                         </option>
                    <?php endforeach; ?>
               </select>
          </div>

          <div class="mb-3">
               <label for="ref_avion" class="form-label">Avion assigné (facultatif)</label>
               <select class="form-select" id="ref_avion" name="ref_avion">
                    <option value="">-- Aucun avion --</option>
                    <?php foreach ($avions as $avion): ?>
                         <option value="<?= htmlspecialchars($avion->getIdAvion()) ?>"
                              <?= $pilote->getRefAvion() == $avion->getIdAvion() ? 'selected' : '' ?>>
                              <?= htmlspecialchars($avion->getImmatriculation()) ?>
                         </option>
                    <?php endforeach; ?>
               </select>
          </div>

          <div class="mb-3">
               <label for="disponible" class="form-label">Disponibilité</label>
               <select class="form-select" id="disponible" name="disponible" required>
                    <?php
                    $options = ['Disponible', 'En vol', 'En congé', 'Indisponible'];
                    foreach ($options as $option) {
                         $selected = ($pilote->getDisponible() === $option) ? 'selected' : '';
                         echo "<option value=\"" . htmlspecialchars($option) . "\" $selected>" . htmlspecialchars($option) . "</option>";
                    }
                    ?>
               </select>
          </div>

          <div class="d-grid gap-2">
               <button type="submit" class="btn btn-warning">Modifier le pilote</button>
               <a href="PilotesRead.php" class="btn btn-secondary">Annuler</a>
          </div>
     </form>
</div>

</body>
</html>
