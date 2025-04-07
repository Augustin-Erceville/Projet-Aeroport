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
     $email = trim($_POST['email'] ?? '');
     $password = $_POST['mot_de_passe'] ?? '';

     if (empty($email) || empty($password)) {
          $_SESSION['error'] = "Veuillez remplir tous les champs.";
          header("Location: ../../views/Connexion.php");
          exit();
     }

     $config = new Config();
     $connexion = $config->connexion();
     $repo = new UtilisateursRepository($connexion);

     $user = $repo->connexion($email, $password);

     if ($user) {
          // Connexion réussie
          $_SESSION['utilisateur'] = [
               'id' => $user->getIdUser(),
               'prenom' => $user->getPrenom(),
               'nom' => $user->getNom(),
               'email' => $user->getEmail()
          ];
          $_SESSION['success'] = "Connexion réussie. Bienvenue " . $user->getPrenom() . " !";
          header("Location: ../../views/Acceuil.php");
          exit();
     } else {
          // Échec de connexion
          $_SESSION['error'] = "Email ou mot de passe incorrect.";
          header("Location: ../../views/Connexion.php");
          exit();
     }
}
?>
