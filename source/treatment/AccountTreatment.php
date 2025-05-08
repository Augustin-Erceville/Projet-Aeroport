<?php
session_start();
require_once '../bdd/config.php';
require_once '../repository/UtilisateursRepository.php';
require_once '../model/UtilisateursModel.php';

if (!isset($_SESSION['utilisateur']) || !isset($_SESSION['utilisateur']['id'])) {
    header('Location: ../../views/Connexion.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../views/Account/AccountView.php');
    exit();
}

$config = new Config();
$bdd = $config->connexion();
$utilisateurRepository = new UtilisateursRepository($bdd);

if (isset($_POST['supprimer_compte'])) {
    $id_user = $_SESSION['utilisateur']['id'];

    if ($utilisateurRepository->deleteUser($id_user)) {
        session_destroy();
        header('Location: ../../views/Connexion.php?message=suppression_reussie');
        exit();
    } else {
        header('Location: ../../views/Account/AccountView.php?error=suppression_echouee');
        exit();
    }
}

$prenom = htmlspecialchars(trim($_POST['prenom'] ?? ''));
$nom = htmlspecialchars(trim($_POST['nom'] ?? ''));
$email = htmlspecialchars(trim($_POST['email'] ?? ''));
$telephone = htmlspecialchars(trim($_POST['telephone'] ?? ''));
$ville_residence = htmlspecialchars(trim($_POST['ville_residence'] ?? ''));
$date_naissance = htmlspecialchars(trim($_POST['date_naissance'] ?? ''));

if (empty($prenom) || empty($nom) || empty($email)) {
    header('Location: ../../views/Account/AccountEdit.php?error=emptyfields');
    exit();
}

$id_user = $_SESSION['utilisateur']['id'];

$utilisateur = new UtilisateursModel();
$utilisateur->setIdUser($id_user);
$utilisateur->setPrenom($prenom);
$utilisateur->setNom($nom);
$utilisateur->setEmail($email);
$utilisateur->setTelephone($telephone);
$utilisateur->setVilleResidence($ville_residence);
$utilisateur->setDateNaissance($date_naissance);

if ($utilisateurRepository->updateUser($utilisateur)) {
    $_SESSION['utilisateur'] = [
        'id' => $utilisateur->getIdUser(),
        'prenom' => $utilisateur->getPrenom(),
        'nom' => $utilisateur->getNom(),
        'email' => $utilisateur->getEmail(),
        'telephone' => $utilisateur->getTelephone(),
        'ville_residence' => $utilisateur->getVilleResidence(),
        'date_naissance' => $utilisateur->getDateNaissance(),
    ];
    header('Location: ../../views/Account/AccountView.php?success=1');
    exit();
} else {
    header('Location: ../../views/Account/AccountView.php?error=modification');
    exit();
}
?>
