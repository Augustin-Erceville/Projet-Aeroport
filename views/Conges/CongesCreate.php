<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once '../../source/bdd/config.php';
require_once '../../source/repository/PilotesRepository.php';
require_once '../../source/repository/UtilisateursRepository.php';

$config = new Config();
$bdd = $config->connexion();
$piloteRepo = new PilotesRepository($bdd);
$utilisateurRepo = new UtilisateursRepository($bdd);
$pilotes = $piloteRepo->getPilotes();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>CONGÉS • ADMIN • AEROPORTAL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom bg-dark">
    <div class="col-2 ms-3 mb-2 mb-md-0 text-light">
         <a href="../Acceuil.php" class="d-inline-flex link-body-emphasis text-decoration-none">
              <img src="../documentation/img/Logo.png" class="rounded-circle mx-3" style="max-width: 15%; height: auto;">
              <div class="fs-4 text-light">AEROPORTAL</div>
         </a>
    </div>
    <ul class="nav col mb-2 justify-content-center mb-md-0">
        <li><a href="../Acceuil.php" class="nav-link px-2"><button type="button" class="btn btn-outline-info">Acceuil</button></a></li>
        <li><a href="../Avions/AvionsRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion avions</button></a></li>
        <li><a href="../Compagnies/CompagniesRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion compagnies</button></a></li>
        <li><a href="../Conges/CongesRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light active">Gestion congés</button></a></li>
        <li><a href="../Pilotes/PilotesRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion pilotes</button></a></li>
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
    <h2 class="text-center mb-4">Ajouter un congé</h2>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form method="post" action="../../source/treatment/CongesTreatment.php">
        <input type="hidden" name="action" value="create">

        <div class="mb-3">
            <label for="ref_pilote" class="form-label">Pilote concerné</label>
            <select class="form-select" id="ref_pilote" name="ref_pilote" required>
                <option value="">-- Sélectionner un pilote --</option>
                <?php foreach ($pilotes as $pilote): ?>
                    <?php
                    $utilisateur = $utilisateurRepo->getUserById($pilote->getRefUtilisateur());
                    ?>
                    <option value="<?= $pilote->getIdPilote() ?>">
                        <?= htmlspecialchars($utilisateur->getPrenom() . ' ' . $utilisateur->getNom()) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="date_debut" class="form-label">Date de début</label>
            <input type="date" class="form-control" id="date_debut" name="date_debut" required>
        </div>

        <div class="mb-3">
            <label for="date_fin" class="form-label">Date de fin</label>
            <input type="date" class="form-control" id="date_fin" name="date_fin" required>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-success">Créer le congé</button>
            <a href="CongesRead.php" class="btn btn-secondary">Annuler</a>
        </div>
    </form>
</div>
<?php include '../Footer.php'; ?>
