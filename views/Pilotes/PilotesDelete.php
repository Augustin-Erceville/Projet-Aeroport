<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once '../../source/bdd/config.php';
require_once '../../source/repository/PilotesRepository.php';

$config = new Config();
$bdd = $config->connexion();
$piloteRepo = new PilotesRepository($bdd);
$id = $_GET['id'] ?? null;
if (!$id) {
     $_SESSION['error'] = "Identifiant du pilote non fourni.";
     header('Location: PilotesRead.php');
     exit();
}

$pilote = $piloteRepo->getPiloteById((int)$id);
if (!$pilote) {
     $_SESSION['error'] = "Pilote introuvable.";
     header('Location: PilotesRead.php');
     exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
     <meta charset="UTF-8">
     <title>Supprimer un Pilote</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
     <h2 class="text-center mb-4 text-danger">Supprimer un pilote</h2>

     <div class="alert alert-warning text-center">
          <p>Êtes-vous sûr de vouloir supprimer ce pilote (ID: <?= htmlspecialchars($pilote->getIdPilote()) ?>) ?</p>

          <div class="d-grid gap-2 d-md-flex justify-content-md-center">
               <a href="../../source/treatment/PilotesTreatment.php?action=delete&id=<?= htmlspecialchars($pilote->getIdPilote()) ?>" class="btn btn-danger">Oui, supprimer</a>
               <a href="PilotesRead.php" class="btn btn-secondary">Annuler</a>
          </div>
     </div>
</div>

</body>
</html>
