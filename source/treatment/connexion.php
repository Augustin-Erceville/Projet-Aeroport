<?php
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

          $user = $repo->getUserByEmail($email);

          if ($user) {
               if (password_verify($password, $user->getMotDePasse())) {
                    $_SESSION['utilisateur'] = [
                        'id' => $user->getIdUser(),
                        'prenom' => $user->getPrenom(),
                        'nom' => $user->getNom(),
                        'email' => $user->getEmail()
                    ];
                    header("Location: ../../views/Acceuil.php");
                    exit();
               } else {
                    $_SESSION['error'] = "Email ou mot de passe incorrect.";
               }
          } else {
               $_SESSION['error'] = "Email ou mot de passe incorrect.";
          }

          header("Location: ../../views/Connexion.php");
          exit();

     } catch (PDOException $e) {
          $_SESSION['error'] = "Erreur serveur : " . $e->getMessage();
          header("Location: ../../views/Connexion.php");
          exit();
     }
} else {
     header("Location: ../../views/Connexion.php");
     exit();
}
?>