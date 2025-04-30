<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../../source/bdd/config.php';
require_once __DIR__ . '/../../source/model/AvionsModel.php';
require_once __DIR__ . '/../../source/repository/AvionsRepository.php';

$config         = new Config();
$bdd            = $config->connexion();
$avionRepo      = new AvionsRepository($bdd);

if (!isset($_GET['id'])) {
     die('ID de l\'avion manquant.');
}

$id = intval($_GET['id']);
$avionData = $avionRepo->getAvionById($id);

if (!$avionData) {
     die('Avion non trouvé.');
}

$avion = new AvionModel();
$avion->hydrate((array)$avionData);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $immatriculation = $_POST['immatriculation'] ?? '';
     $modele = $_POST['modele'] ?? '';
     $capacite = $_POST['capacite'] ?? 0;
     $ref_compagnie = $_POST['ref_compagnie'] ?? 0;

     $avion->setImmatriculation($immatriculation);
     $avion->setModele($modele);
     $avion->setCapacite($capacite);
     $avion->setRefCompagnie($ref_compagnie);

     $avionRepo->updateAvion($avion);

     header('Location: AvionsRead.php?success=updated');
     exit;
}
?>

<!doctype html>
<html lang="fr">
<head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>AEROPORTAL - MODIFICATION AVIONS</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
           integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
           crossorigin="anonymous">
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
               <a href="../../source/treatment/deconnexion.php" class="btn btn-outline-danger">DÉCONNEXION</a>
          <?php else: ?>
               <a href="Connexion.php" class="btn btn-outline-success">CONNEXION</a>
               <a href="Inscription.php" class="btn btn-outline-primary">INSCRIPTION</a>
          <?php endif; ?>
     </div>
</header>
<div class="container">
     <h4 class="text-uppercase text-center">Modifier un avion</h4>

     <?php if (isset($error_message)): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8') ?></div>
     <?php endif; ?>

     <form method="post" class="mt-4">
          <div class="mb-3">
               <label for="immatriculation" class="form-label">Immatriculation</label>
               <input type="text" class="form-control" name="immatriculation" id="immatriculation" required value="<?= htmlspecialchars($avion->getImmatriculation()) ?>">
          </div>
          <div class="mb-3">
               <label for="modele" class="form-label">Modèle</label>
               <input type="text" class="form-control" name="modele" id="modele" required value="<?= htmlspecialchars($avion->getModele()) ?>">
          </div>
          <div class="mb-3">
               <label for="capacite" class="form-label">Capacité</label>
               <input type="number" class="form-control" name="capacite" id="capacite" required value="<?= htmlspecialchars($avion->getCapacite()) ?>">
          </div>
          <div class="mb-3">
               <label for="ref_compagnie" class="form-label">Référence Compagnie</label>
               <input type="number" class="form-control" name="ref_compagnie" id="ref_compagnie" required value="<?= htmlspecialchars($avion->getRefCompagnie()) ?>">
          </div>
          <button type="submit" class="btn btn-primary">Modifier</button>
     </form>
</div>
<?php include '../Footer.php'; ?>