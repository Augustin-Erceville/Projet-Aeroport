<?php
require_once __DIR__ . '/../../source/bdd/config.php';
require_once __DIR__ . '/../../source/repository/UtilisateursRepository.php';
require_once __DIR__ . '/../../source/repository/VolsRepository.php';

$config = new Config();
$connexion = $config->connexion();

$utilisateurRepository = new UtilisateursRepository($connexion);
$volRepository = new VolsRepository($connexion);

$utilisateurs = $utilisateurRepository->getUsers();
$vols = $volRepository->getVols();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>RESERVATIONS • ADMIN • AEROPORTAL</title>
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
        <li><a href="../Conges/CongesRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion congés</button></a></li>
        <li><a href="../Pilotes/PilotesRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion pilotes</button></a></li>
        <li><a href="../Reservations/ReservationsRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light active">Gestion réservations</button></a></li>
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
    <h2 class="mb-4 text-center">Ajouter une reservation</h2>

    <?php if (!empty($erreur)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
    <?php endif; ?>

    <form action="../../source/treatment/ReservationsTreatment.php" method="post">
        <div class="mb-3">
            <label for="ref_utilisateur" class="form-label">Utilisateur</label>
            <select class="form-select" name="ref_utilisateur" id="ref_utilisateur" required>
                <?php foreach ($utilisateurs as $utilisateur): ?>
                    <option value="<?= htmlspecialchars($utilisateur->getIdUser()) ?>">
                        <?= htmlspecialchars($utilisateur->getPrenom() . ' ' . $utilisateur->getNom()) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="ref_vol" class="form-label">Vol</label>
            <select class="form-select" name="ref_vol" id="ref_vol" required>
                <?php foreach ($vols as $vol): ?>
                    <option value="<?= htmlspecialchars($vol['id_vol']) ?>">
                        <?= htmlspecialchars($vol['numero_vol']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="mb-3">
            <label for="classe" class="form-label">Classe</label>
            <select class="form-select" name="classe" id="classe" required>
                <option value="Économique">Économique</option>
                <option value="Affaires">Affaires</option>
                <option value="Première">Première</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="statut" class="form-label">Statut</label>
            <select class="form-select" name="statut" id="statut" required>
                <option value="confirmé">Confirmé</option>
                <option value="annulé">Annulé</option>
                <option value="en attente">En attente</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="date_reservation" class="form-label">Date et heure de réservation</label>
            <input type="datetime-local" class="form-control" name="date_reservation" id="date_reservation" required>
        </div>

        <button type="submit" name="addReservation" class="btn btn-success">Ajouter</button>
        <a href="ReservationsRead.php" class="btn btn-secondary">Retour</a>
    </form>
</div>
<?php include '../Footer.php'; ?>
</body>
</html>
