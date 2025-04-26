<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../../source/repository/CompagniesRepository.php';
require_once __DIR__ . '/../../source/bdd/config.php';
require_once __DIR__ . '/../../source/model/CompagniesModel.php';

$config         = new Config();
$bdd            = $config->connexion();
$compagnieRepo  = new repository\CompagniesRepository($bdd);

// Vérifier si l'ID est passé dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];
    $compagnie = $compagnieRepo->getCompagnieById($id);
} else {
    // Redirection en cas d'ID manquant ou invalide
    header("Location: CompagniesRead.php");
    exit();
}

// Traitement du formulaire de mise à jour
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom    = $_POST['nom'];
    $pays   = $_POST['pays'];

    // Validation des données reçues
    if (!empty($nom) && !empty($pays)) {
        // Mise à jour dans la base de données
        $compagnie->setNom($nom);
        $compagnie->setPays($pays);
        $compagnieRepo->updateCompagnie($compagnie);

        // Redirection après la mise à jour
        header("Location: CompagniesRead.php");
        exit();
    } else {
        $error_message = "Tous les champs doivent être remplis.";
    }
}
?>

<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AEROPORTAL - MODIFICATION COMPAGNIE</title>
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
        <li><a href="../Avions/AvionsRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion avions</button></a></li>
        <li><a href="../Compagnies/CompagniesRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light active">Gestion compagnies</button></a></li>
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
    <h4 class="text-uppercase text-center">Modifier la compagnie</h4>

    <?php if (isset($error_message)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error_message, ENT_QUOTES, 'UTF-8') ?></div>
    <?php endif; ?>

    <form method="POST" action="CompagniesUpdate.php?id=<?= $compagnie->getId() ?>">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom de la compagnie</label>
            <input type="text" class="form-control" id="nom" name="nom" value="<?= htmlspecialchars($compagnie->getNom(), ENT_QUOTES, 'UTF-8') ?>" required>
        </div>
        <div class="mb-3">
            <label for="pays" class="form-label">Pays</label>
            <input type="text" class="form-control" id="pays" name="pays" value="<?= htmlspecialchars($compagnie->getPays(), ENT_QUOTES, 'UTF-8') ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
</body>
</html>
