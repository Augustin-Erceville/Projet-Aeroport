<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('../bdd/config.php');
require_once('../model/UtilisateursModel.php');
require_once('../repository/UtilisateursRepository.php');

session_start();
use repository\UtilisateursRepository;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
     $nom = htmlspecialchars(trim($_POST['nom'] ?? ''));
     $prenom = htmlspecialchars(trim($_POST['prenom'] ?? ''));
     $email = trim($_POST['email'] ?? '');
     $telephone = trim($_POST['telephone'] ?? '');
     $date_naissance = $_POST['date_naissance'] ?? '';
     $ville_residence = htmlspecialchars(trim($_POST['ville_residence'] ?? ''));
     $mdp = $_POST['mot_de_passe'] ?? '';
     $mdp_confirm = $_POST['confirmation_mot_de_passe'] ?? '';

     if (
          empty($nom) || empty($prenom) || empty($email) || empty($mdp) || empty($mdp_confirm) ||
          empty($telephone) || empty($date_naissance) || empty($ville_residence)
     ) {
          $_SESSION['error'] = "Tous les champs doivent être remplis.";
          header("Location: ../../views/Inscription.php");
          exit();
     }

     if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $_SESSION['error'] = "Email invalide.";
          header("Location: ../../views/Inscription.php");
          exit();
     }

     if (!preg_match('/^[0-9]{10}$/', $telephone)) {
          $_SESSION['error'] = "Numéro de téléphone invalide.";
          header("Location: ../../views/Inscription.php");
          exit();
     }

     if (!DateTime::createFromFormat('Y-m-d', $date_naissance)) {
          $_SESSION['error'] = "Date de naissance invalide.";
          header("Location: ../../views/Inscription.php");
          exit();
     }

     if (strlen($mdp) < 8) {
          $_SESSION['error'] = "Le mot de passe doit contenir au moins 8 caractères.";
          header("Location: ../../views/Inscription.php");
          exit();
     }

     if ($mdp !== $mdp_confirm) {
          $_SESSION['error'] = "Les mots de passe ne correspondent pas.";
          header("Location: ../../views/Inscription.php");
          exit();
     }

     $config = new Config();
     $connexion = $config->connexion();
     $repo = new UtilisateursRepository($connexion);

     if ($repo->getUserByEmail($email)) {
          $_SESSION['error'] = "Un utilisateur avec cet email existe déjà.";
          header("Location: ../../views/Inscription.php");
          exit();
     }

     $hash = password_hash($mdp, PASSWORD_DEFAULT);

     $utilisateur = new UtilisateursModel([
          'nom' => $_POST['nom'],
          'prenom' => $_POST['prenom'],
          'telephone' => $_POST['telephone'],
          'email' => $_POST['email'],
          'mot_de_passe' => password_hash($_POST['mot_de_passe'], PASSWORD_BCRYPT),
          'date_naissance' => $_POST['date_naissance'],
          'ville_residence' => $_POST['ville_residence'],
     ]);

     try {
          $repo->ajouterUtilisateur($utilisateur);

          $_SESSION['success'] = "Inscription réussie !";
          header("Location: ../../views/Connexion.php");
          exit();
     } catch (PDOException $e) {
          $_SESSION['error'] = "Erreur lors de l'insertion : " . $e->getMessage();
          header("Location: ../../views/Inscription.php");
          exit();
     }
}
?>