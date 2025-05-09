<?php
session_start();

if (!isset($_SESSION['utilisateur'])) {
     header('Location: Connexion.php');
     exit();
}

$prenom = htmlspecialchars($_SESSION['utilisateur']['prenom']);
?>
<?php include 'Header.php'; ?>
<div class="mx-4">
     <div class="row">
          <h4 class="text-center text-uppercase">Vos reservations</h4>
     </div>
</div>
<?php include 'Footer.php'; ?>