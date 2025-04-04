<!doctype html>
<html lang="fr">
<head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>AEROPORTAL - ACCEUIL</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom bg-dark">
     <div class="col-2 ms-3 mb-2 mb-md-0 text-light">
          <a href="/" class="d-inline-flex link-body-emphasis text-decoration-none">
               <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#FFFFFF" class="bi bi-send-fill" viewBox="0 0 16 16">
                    <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471z"/>
               </svg>
               <div class="fs-4 text-light">AEROPORTAL</div>
          </a>
     </div>

     <ul class="nav col mb-2 justify-content-center mb-md-0">
          <li><a href="acceuil.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Acceuil</button></a></li>
          <li><a href="acheter_billet.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Acheter un billet</button></a></li>
          <li><a href="enregistrement.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Enregistrement</button></a></li>
          <li><a href="reservation.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Mes reservations</button></a></li>
          <li><a href="information.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light active">Informations</button></a></li>
          <li><a href="aide.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Aide</button></a></li>
     </ul>

     <div class=" col-2 btn-group md-3 me-3 text-end" role="group" aria-label="Basic example">
          <a type="button" href="connexion.php" class="btn btn-outline-success">CONNEXION</a>
          <a type="button" href="inscription.php" class="btn btn-outline-primary">INSCRIPTION</a>
     </div>
</header>

<?php include 'footer.php'; ?>