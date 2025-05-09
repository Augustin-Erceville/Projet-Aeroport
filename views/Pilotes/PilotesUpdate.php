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

$utilisateurs = $utilisateurRepo->getUsers();
$avions = $avionRepo->getAvions();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
     <meta charset="UTF-8">
     <title>PILOTES • ADMIN • AEROPORTAL</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom bg-dark">
    <div class="col-2 ms-3 mb-2 mb-md-0 text-light">
         <a href="../Acceuil.php" class="d-inline-flex link-body-emphasis text-decoration-none">
              <img src="../../documentation/img/Logo.png" class="rounded-circle mx-3" style="max-width: 15%; height: auto;">
              <div class="fs-4 text-light">AEROPORTAL</div>
         </a>
    </div>
    <ul class="nav col mb-2 justify-content-center mb-md-0">
        <li><a href="../Acceuil.php" class="nav-link px-2"><button type="button" class="btn btn-outline-info">Acceuil</button></a></li>
        <li><a href="../Avions/AvionsRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion avions</button></a></li>
        <li><a href="../Compagnies/CompagniesRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion compagnies</button></a></li>
        <li><a href="../Conges/CongesRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion congés</button></a></li>
        <li><a href="../Pilotes/PilotesRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light active">Gestion pilotes</button></a></li>
        <li><a href="../Reservations/ReservationsRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion réservations</button></a></li>
        <li><a href="../Utilisateurs/UtilisateursRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion utilisateurs</button></a></li>
        <li><a href="../Vols/VolsRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion vols</button></a></li>
    </ul>
    <div class="col-2 btn-group md-3 me-3 text-end" role="group" aria-label="Boutons utilisateur">
        <?php if (isset($_SESSION['utilisateur'])): ?>
            <a href="../../views/Account/AccountView.php" class="btn btn-outline-primary">MON COMPTE</a>
            <a href="../../source/treatment/deconnexion.php" class="btn btn-outline-danger">DÉCONNEXION</a>
        <?php else: ?>
            <a href="../Connexion.php" class="btn btn-outline-success">CONNEXION</a>
            <a href="../Inscription.php" class="btn btn-outline-primary">INSCRIPTION</a>
        <?php endif; ?>
    </div>
</header>
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
                         <option value="<?= htmlspecialchars($utilisateur->getIdUser()) ?>"
                              <?= $pilote->getRefUtilisateur() == $utilisateur->getIdUser() ? 'selected' : '' ?>>
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
<?php include '../Footer.php'; ?>