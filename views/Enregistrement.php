<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
<!doctype html>
<html lang="fr">
<head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>ENREGISTREMENT • AEROPORTAL</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom bg-dark">
     <div class="col-2 ms-3 mb-2 mb-md-0 text-light">
          <a href="Acceuil.php" class="d-inline-flex link-body-emphasis text-decoration-none">
               <img src="../documentation/img/Logo.png" style="max-width: 15%; height: auto;">
               <div class="fs-4 text-light">AEROPORTAL</div>
          </a>
     </div>

     <ul class="nav col mb-2 justify-content-center mb-md-0">
          <li><a href="Acceuil.php" class="nav-link px-2"><button type="button" class="btn btn-outline-info">Accueil</button></a></li>
          <li><a href="AcheterBillet.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Acheter un billet</button></a></li>
          <li><a href="Enregistrement.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light active">Enregistrement</button></a></li>
          <li><a href="Reservation.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Mes reservations</button></a></li>
          <li><a href="Information.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Informations</button></a></li>
          <li><a href="Aide.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Aide</button></a></li>
         <?php if (isset($_SESSION['utilisateur']) && $_SESSION['utilisateur']['role'] === 'Administrateur'): ?>
             <li><a href="Administration.php" class="nav-link px-2"><button type="button" class="btn btn-outline-warning">Administration</button></a></li>
         <?php endif; ?>
     </ul>

    <div class="col-2 btn-group md-3 me-3 text-end" role="group" aria-label="Boutons utilisateur">
        <?php if (isset($_SESSION['utilisateur'])): ?>
            <a href="../views/Account/AccountView.php" class="btn btn-outline-primary">MON COMPTE</a>
            <a href="../source/treatment/deconnexion.php" class="btn btn-outline-danger">DÉCONNEXION</a>
        <?php else: ?>
            <a href="Connexion.php" class="btn btn-outline-success">CONNEXION</a>
            <a href="Inscription.php" class="btn btn-outline-primary">INSCRIPTION</a>
        <?php endif; ?>
    </div>
</header>
<div class="mx-4">
     <div class="row">
          <h4 class="text-center text-uppercase">Enregistrement</h4>
          <div class="col">
               <div class="row g-0 bg-body-secondary position-relative">
                    <div class="col-md-6 mb-md-0 p-md-4">
                         <img src="https://img.goodfon.com/original/1920x1080/6/5d/vertu-aster-smartphone.jpg" class="w-100" alt="">
                    </div>
                    <div class="col-md-6 p-4 ps-md-0">
                         <h5 class="mt-0">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-phone" viewBox="0 0 16 16">
                                   <path d="M11 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1zM5 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2z"/>
                                   <path d="M8 14a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                              </svg>
                              En ligne</h5>
                         <p><strong>Pour l'enregistrement en ligne, vous avez le choix</strong></p>
                         <p>Dès 30 heures avant le départ de votre vol, gagnez du temps avec l'enregistrement en ligne : vous choisissez votre siège et obtenez votre carte d'embarquement. Elle vous est nécessaire pour monter dans l'avion.</p>
                    </div>
               </div>
          </div>
          <div class="col">
               <div class="row g-0 bg-body-secondary position-relative">
                    <div class="col-md-6 mb-md-0 p-md-4">
                         <img src="https://img3.wallspic.com/crops/4/5/4/3/4/143454/143454-genie_aerospatial-air_voyage-ciel-1920x1080.jpg" class="w-100" alt="">
                    </div>
                    <div class="col-md-6 p-4 ps-md-0">
                         <h5 class="mt-0">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-airplane" viewBox="0 0 16 16">
                                   <path d="M6.428 1.151C6.708.591 7.213 0 8 0s1.292.592 1.572 1.151C9.861 1.73 10 2.431 10 3v3.691l5.17 2.585a1.5 1.5 0 0 1 .83 1.342V12a.5.5 0 0 1-.582.493l-5.507-.918-.375 2.253 1.318 1.318A.5.5 0 0 1 10.5 16h-5a.5.5 0 0 1-.354-.854l1.319-1.318-.376-2.253-5.507.918A.5.5 0 0 1 0 12v-1.382a1.5 1.5 0 0 1 .83-1.342L6 6.691V3c0-.568.14-1.271.428-1.849m.894.448C7.111 2.02 7 2.569 7 3v4a.5.5 0 0 1-.276.447l-5.448 2.724a.5.5 0 0 0-.276.447v.792l5.418-.903a.5.5 0 0 1 .575.41l.5 3a.5.5 0 0 1-.14.437L6.708 15h2.586l-.647-.646a.5.5 0 0 1-.14-.436l.5-3a.5.5 0 0 1 .576-.411L15 11.41v-.792a.5.5 0 0 0-.276-.447L9.276 7.447A.5.5 0 0 1 9 7V3c0-.432-.11-.979-.322-1.401C8.458 1.159 8.213 1 8 1s-.458.158-.678.599"/>
                              </svg>
                              Sur place</h5>
                         <p><strong>Les bornes Air France sont là pour vous 24h/24 !</strong></p>
                         <p>Vous enregistrer à l’aéroport le jour de votre vol, c’est possible jusqu’à l’heure de fin d’enregistrement : choisissez votre siège et obtenez votre carte d'embarquement. Elle est nécessaire pour monter dans l'avion.</p>

                    </div>
               </div>
          </div>
     </div>
</div>
<?php include 'Footer.php'; ?>