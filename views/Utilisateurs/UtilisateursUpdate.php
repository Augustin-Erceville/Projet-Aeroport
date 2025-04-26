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
$utilisateurRepo = new repository\UtilisateursRepository($bdd);
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
    <title>Mettre à jour l'utilisateur</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

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

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
