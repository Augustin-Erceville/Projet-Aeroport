<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['utilisateur'])) {
    header('Location: ../Connexion.php');
    exit();
}

$utilisateur = $_SESSION['utilisateur'];
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>COMPTE • AEROPORTAL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
        <li><a href="../Acceuil.php" class="nav-link px-2"><button type="button" class="btn btn-outline-info active">Accueil</button></a></li>
        <li><a href="../AcheterBillet.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Acheter un billet</button></a></li>
        <li><a href="../Enregistrement.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Enregistrement</button></a></li>
        <li><a href="../Reservation.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Mes réservations</button></a></li>
        <li><a href="../Information.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Informations</button></a></li>
        <li><a href="../Aide.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Aide</button></a></li>
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

<div class="container my-4">
    <div class="row">
        <h2 class="text-center text-uppercase mb-4">Mon compte</h2>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-center mb-4">Informations personnelles</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item"><strong>Prénom :</strong> <?= htmlspecialchars($utilisateur['prenom']) ?></li>
                        <li class="list-group-item"><strong>Nom :</strong> <?= htmlspecialchars($utilisateur['nom']) ?></li>
                        <li class="list-group-item"><strong>Email :</strong> <?= htmlspecialchars($utilisateur['email']) ?></li>
                        <li class="list-group-item"><strong>Téléphone :</strong> <?= isset($utilisateur['telephone']) ? htmlspecialchars($utilisateur['telephone']) : 'Non renseigné' ?></li>
                        <li class="list-group-item"><strong>Ville de résidence :</strong> <?= isset($utilisateur['ville_residence']) ? htmlspecialchars($utilisateur['ville_residence']) : 'Non renseignée' ?></li>
                        <li class="list-group-item"><strong>Date de naissance :</strong> <?= isset($utilisateur['date_naissance']) ? htmlspecialchars($utilisateur['date_naissance']) : 'Non renseignée' ?></li>
                    </ul>

                    <div class="d-grid gap-2 mt-4">
                        <a href="AccountEdit.php" class="btn btn-outline-warning">Modifier</a>
                        <a href="AccountDelete.php" class="btn btn-outline-danger">Supprimer</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include '../Footer.php'; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoIIfJcLyjU29tka7Sk3YSA8l7IgGKmFckcImFV8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>
