<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!doctype html>
<html lang="fr">
<head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>AEROPORTAL - INFORMATION</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom bg-dark">
     <div class="col-2 ms-3 mb-2 mb-md-0 text-light">
          <a href="acceuil.php" class="d-inline-flex link-body-emphasis text-decoration-none">
               <img src="../documentation/img/Logo.png" style="max-width: 15%; height: auto;">
               <div class="fs-4 text-light">AEROPORTAL</div>
          </a>
     </div>

     <ul class="nav col mb-2 justify-content-center mb-md-0">
          <li><a href="acceuil.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Accueil</button></a></li>
          <li><a href="acheter_billet.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Acheter un billet</button></a></li>
          <li><a href="enregistrement.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Enregistrement</button></a></li>
          <li><a href="reservation.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Mes reservations</button></a></li>
          <li><a href="information.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light active">Informations</button></a></li>
          <li><a href="aide.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Aide</button></a></li>
     </ul>

     <div class="col-2 btn-group md-3 me-3 text-end" role="group" aria-label="Boutons utilisateur">
          <?php if (isset($_SESSION['utilisateur'])): ?>
               <a href="../source/treatment/deconnexion.php" class="btn btn-outline-danger">DÉCONNEXION</a>
          <?php else: ?>
               <a href="connexion.php" class="btn btn-outline-success">CONNEXION</a>
               <a href="inscription.php" class="btn btn-outline-primary">INSCRIPTION</a>
          <?php endif; ?>
     </div>
</header>
<div class="mx-4">
     <div class="row">
          <h4 class="text-center text-uppercase">Informations utiles</h4>
     </div>
</div>
<?php include 'footer.php'; ?>