<?php

use repository\CompagniesRepository;

if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../../source/bdd/config.php';
require_once __DIR__ . '/../../source/model/AvionsModel.php';
require_once __DIR__ . '/../../source/repository/AvionsRepository.php';
require_once __DIR__ . '/../../source/model/CompagniesModel.php';
require_once __DIR__ . '/../../source/repository/CompagniesRepository.php';

$config = new Config();
$bdd = $config->connexion();

$avionRepo = new AvionsRepository($bdd);
$compagnieRepo = new CompagniesRepository($bdd);
$compagnies = $compagnieRepo->getCompagnies();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $immatriculation = isset($_POST['immatriculation']) ? trim($_POST['immatriculation']) : '';
     $type           = isset($_POST['type']) ? trim($_POST['type']) : '';
     $capacite       = isset($_POST['capacite']) ? (int) $_POST['capacite'] : 0;
     $id_compagnie   = isset($_POST['compagnie']) ? (int) $_POST['compagnie'] : 0;

     if (!empty($immatriculation) && !empty($type) && $capacite > 0 && $id_compagnie > 0) {
          $avion = new AvionModel(null, $immatriculation, $type, $capacite, $id_compagnie);
          $avionRepo->createAvion($avion);
          header('Location: AvionsRead.php?success=created');
          exit;
     } else {
          $error = "Tous les champs sont obligatoires et la capacité doit être positive.";
     }
}
?>
<!doctype html>
<html lang="fr">
<head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>AEROPORTAL – GESTION AVIONS</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<header class="d-flex flex-wrap align-items-center justify-content-between py-3 mb-4 border-bottom bg-dark">
     <div class="col-2 ms-3 text-light">
          <a href="../Acceuil.php" class="d-flex align-items-center text-decoration-none text-light">
               <img src="../../documentation/img/Logo.png" style="max-width: 15%; height: auto;">
               <div class="fs-4 ms-2">AEROPORTAL</div>
          </a>
     </div>
     <ul class="nav col justify-content-center">
          <li><a href="../Acceuil.php" class="nav-link px-2"><button class="btn btn-outline-info">Accueil</button></a></li>
          <li><a href="AvionsRead.php" class="nav-link px-2"><button class="btn btn-outline-light active">Gestion avions</button></a></li>
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
               <a href="Connexion.php" class="btn btn-outline-success">CONNEXION</a>
               <a href="Inscription.php" class="btn btn-outline-primary">INSCRIPTION</a>
          <?php endif; ?>
     </div>
</header>

<div class="container mt-5">
     <h3 class="mb-4">Ajouter un avion</h3>

     <?php if (isset($error)) : ?>
          <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
     <?php elseif (isset($_GET['success']) && $_GET['success'] === 'created') : ?>
          <div class="alert alert-success">L'avion a été ajouté avec succès !</div>
     <?php endif; ?>

     <form method="post" class="row g-3">
          <div class="col-md-6">
               <label for="immatriculation" class="form-label">Immatriculation :</label>
               <input type="text" id="immatriculation" name="immatriculation" class="form-control" minlength="6" maxlength="6" required>
          </div>

          <div class="col-md-6">
               <label for="type" class="form-label">Type :</label>
               <input type="text" id="type" name="type" class="form-control" required>
          </div>

          <div class="col-md-6">
               <label for="capacite" class="form-label">Capacité :</label>
               <input type="number" id="capacite" name="capacite" min="1" class="form-control" required>
          </div>

          <div class="col-md-6">
               <label for="compagnie" class="form-label">Compagnie :</label>
               <select name="compagnie" id="compagnie" class="form-select" required>
                    <option value="">-- Sélectionner une compagnie --</option>
                    <?php foreach ($compagnies as $compagnie) : ?>
                         <option value="<?= htmlspecialchars($compagnie->getIdCompagnie()) ?>">
                         <?= htmlspecialchars($compagnie->getNom()) ?> (<?= htmlspecialchars($compagnie->getPays()) ?>)
                         </option>
                    <?php endforeach; ?>
               </select>
          </div>

          <div class="col-12">
               <button type="submit" class="btn btn-primary">Ajouter l'avion</button>
          </div>
     </form>
</div>
</body>
</html>
