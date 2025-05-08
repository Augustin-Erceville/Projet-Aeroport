<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

require_once('../bdd/config.php');
require_once('../model/UtilisateursModel.php');
require_once('../repository/UtilisateursRepository.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
     $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
     $password = $_POST['mot_de_passe'] ?? '';

     if (!$email || empty($password)) {
          $_SESSION['error'] = "Veuillez remplir tous les champs correctement.";
          header("Location: ../../views/Connexion.php");
          exit();
     }

     try {
          $config = new Config();
          $connexion = $config->connexion();
          $repo = new UtilisateursRepository($connexion);

          $user = $repo->connexion($email, $password);

          if ($user) {
               $_SESSION['utilisateur'] = [
                   'id' => $user->getIdUser(),
                   'prenom' => $user->getPrenom(),
                   'nom' => $user->getNom(),
                   'email' => $user->getEmail(),
                   'telephone' => $user->getTelephone(),
                   'ville_residence' => $user->getVilleResidence(),
                   'date_naissance' => $user->getDateNaissance()
               ];

               $_SESSION['success'] = "Connexion réussie. Bienvenue " . htmlspecialchars($user->getPrenom()) . " !";
               header("Location: ../../views/Acceuil.php");
               exit();
          } else {
               $_SESSION['error'] = "Email ou mot de passe incorrect.";
               header("Location: ../../views/Connexion.php");
               exit();
          }
     } catch (Exception $e) {
          $_SESSION['error'] = "Une erreur est survenue : " . $e->getMessage();
          header("Location: ../../views/Connexion.php");
          exit();
     }
} else {
     // Redirection si accès non autorisé
     header("Location: ../../views/Connexion.php");
     exit();
}
?>
