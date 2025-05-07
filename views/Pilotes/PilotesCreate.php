<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once '../../source/bdd/config.php';
require_once '../../source/repository/UtilisateursRepository.php';
require_once '../../source/repository/AvionsRepository.php';

$config = new Config();
$bdd = $config->connexion();

$utilisateurRepo = new UtilisateursRepository($bdd);
$avionRepo = new AvionsRepository($bdd);

try {
     $utilisateurs = $utilisateurRepo->getUtilisateurs();
     $avions = $avionRepo->getAvions();
} catch (PDOException $e) {
     die("Erreur lors de la récupération des données : " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
     <meta charset="UTF-8">
     <title>Créer un Pilote</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
     <h2 class="text-center mb-4">Ajouter un pilote</h2>

     <?php if (isset($_SESSION['error'])): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
          <?php unset($_SESSION['error']); ?>
     <?php endif; ?>

     <form method="post" action="../../source/treatment/PilotesTreatment.php">
          <input type="hidden" name="action" value="create">

          <div class="mb-3">
               <label for="ref_utilisateur" class="form-label">Utilisateur associé</label>
               <select class="form-select" id="ref_utilisateur" name="ref_utilisateur" required>
                    <option value="">-- Sélectionner un utilisateur --</option>
                    <?php if (!empty($utilisateurs)): ?>
                         <?php foreach ($utilisateurs as $utilisateur): ?>
                              <option value="<?= htmlspecialchars($utilisateur->getIdUtilisateur()) ?>">
                                   <?= htmlspecialchars($utilisateur->getPrenom() . ' ' . $utilisateur->getNom()) ?>
                              </option>
                         <?php endforeach; ?>
                    <?php endif; ?>
               </select>
          </div>

          <div class="mb-3">
               <label for="ref_avion" class="form-label">Avion assigné (facultatif)</label>
               <select class="form-select" id="ref_avion" name="ref_avion">
                    <option value="">-- Aucun avion --</option>
                    <?php if (!empty($avions)): ?>
                         <?php foreach ($avions as $avion): ?>
                              <option value="<?= htmlspecialchars($avion->getIdAvion()) ?>">
                                   <?= htmlspecialchars($avion->getImmatriculation()) ?>
                              </option>
                         <?php endforeach; ?>
                    <?php endif; ?>
               </select>
          </div>

          <div class="mb-3">
               <label for="disponible" class="form-label">Disponibilité</label>
               <select class="form-select" id="disponible" name="disponible" required>
                    <option value="">-- Sélectionner une disponibilité --</option>
                    <option value="Disponible">Disponible</option>
                    <option value="En vol">En vol</option>
                    <option value="En congé">En congé</option>
                    <option value="Indisponible">Indisponible</option>
               </select>
          </div>

          <div class="d-grid gap-2">
               <button type="submit" class="btn btn-success">Créer le pilote</button>
               <a href="PilotesRead.php" class="btn btn-secondary">Annuler</a>
          </div>
     </form>
</div>
