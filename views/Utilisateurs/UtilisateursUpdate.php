<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/../../source/repository/UtilisateursRepository.php';
require_once __DIR__ . '/../../source/bdd/config.php';
require_once __DIR__ . '/../../source/model/UtilisateursModel.php';

$id = $_GET['id'] ?? null;


if ($id === null) {
    die('L\'utilisateur est introuvable.');
}
$config = new Config();
$bdd = $config->connexion();
$utilisateurRepo = new UtilisateursRepository($bdd);
$user = $utilisateurRepo->getUserById($id);

if (!$user) {
    die("Utilisateur introuvable.");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $prenom = $_POST['prenom'] ?? '';
    $nom = $_POST['nom'] ?? '';
    $telephone = $_POST['telephone'] ?? '';
    $email = $_POST['email'] ?? '';
    $date_naissance = $_POST['date_naissance'] ?? '';
    $ville_residence = $_POST['ville_residence'] ?? '';

    $updatedUser = new UtilisateursModel([
        'id_utilisateur' => $id,
        'prenom' => $prenom,
        'nom' => $nom,
        'telephone' => $telephone,
        'email' => $email,
        'date_naissance' => $date_naissance,
        'ville_residence' => $ville_residence
    ]);

    $utilisateurRepo->updateUser($updatedUser);

    header('Location: UtilisateursRead.php');
    exit;
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>UTILISATEURS • ADMIN • AEROPORTAL</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
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
        <li><a href="../Reservations/ReservationsRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion réservations</button></a></li>
        <li><a href="../Utilisateurs/UtilisateursRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light active">Gestion utilisateurs</button></a></li>
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
<div class="container">
    <h2 class="mt-5">Mettre à jour l'utilisateur</h2>

    <form method="POST">
        <div class="form-group">
            <label for="prenom">Prénom</label>
            <input type="text" class="form-control" id="prenom" name="prenom" value="<?php echo htmlspecialchars($user->getPrenom()); ?>" required>
        </div>
        <div class="form-group">
            <label for="nom">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" value="<?php echo htmlspecialchars($user->getNom()); ?>" required>
        </div>
        <div class="form-group">
            <label for="telephone">Téléphone</label>
            <input type="text" class="form-control" id="telephone" name="telephone" value="<?php echo htmlspecialchars($user->getTelephone()); ?>" required>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($user->getEmail()); ?>" required>
        </div>
        <div class="form-group">
            <label for="date_naissance">Date de naissance</label>
            <input type="date" class="form-control" id="date_naissance" name="date_naissance" value="<?php echo htmlspecialchars($user->getDateNaissance()); ?>" required>
        </div>
        <div class="form-group">
            <label for="ville_residence">Ville de résidence</label>
            <input type="text" class="form-control" id="ville_residence" name="ville_residence" value="<?php echo htmlspecialchars($user->getVilleResidence()); ?>" required>
        </div>
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>
<?php include '../Footer.php'; ?>