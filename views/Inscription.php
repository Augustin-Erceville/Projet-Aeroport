<?php session_start(); ?>
<!doctype html>
<html lang="fr">
<head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>AEROPORTAL - INSCRIPTION</title>
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
          <li><a href="Enregistrement.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Enregistrement</button></a></li>
          <li><a href="Reservation.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Mes reservations</button></a></li>
          <li><a href="Information.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Informations</button></a></li>
          <li><a href="Aide.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Aide</button></a></li>
     </ul>

     <div class="col-2 btn-group md-3 me-3 text-end" role="group" aria-label="Boutons utilisateur">
          <?php if (isset($_SESSION['utilisateur'])): ?>
               <a href="../source/treatment/deconnexion.php" class="btn btn-outline-danger">DÉCONNEXION</a>
          <?php else: ?>
               <a href="Connexion.php" class="btn btn-outline-success">CONNEXION</a>
               <a href="Inscription.php" class="btn btn-outline-primary active">INSCRIPTION</a>
          <?php endif; ?>
     </div>
</header>

<div class="row">
     <div class="col">
     </div>
     <div class="col">
          <h4 class="text-center">INSCRIPTION</h4>
          <?php if (isset($_SESSION['error'])): ?>
               <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
               </div>
          <?php endif; ?>

          <?php if (isset($_SESSION['success'])): ?>
               <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
               </div>
          <?php endif; ?>
          <form action="../source/treatment/inscription.php" method="post" class="align-self-center">
               <div class="form-floating my-2">
                    <input type="text" name="prenom" class="form-control" id="floatingPrenom" placeholder="Prénom" required>
                    <label for="floatingPrenom">Prénom</label>
               </div>
               <div class="form-floating my-2">
                    <input type="text" name="nom" class="form-control" id="floatingNom" placeholder="Nom de famille" required>
                    <label for="floatingNom">Nom de famille</label>
               </div>
               <div class="form-floating my-2">
                    <input type="tel" name="telephone" class="form-control" id="floatingTel" placeholder="Numéro de téléphone" required>
                    <label for="floatingTel">Numéro de téléphone</label>
               </div>
               <div class="form-floating my-2">
                    <input type="email" name="email" class="form-control" id="floatingEmail" placeholder="Adresse email" required>
                    <label for="floatingEmail">Adresse email</label>
               </div>
               <div class="form-floating my-2">
                    <input type="password" name="mot_de_passe" class="form-control" id="floatingMdp" placeholder="Mot de passe" required>
                    <label for="floatingMdp">Mot de passe</label>
               </div>
               <div class="form-floating my-2">
                    <input type="password" name="confirmation_mot_de_passe" class="form-control" id="floatingMdpConfirm" placeholder="Confirmation du mot de passe" required>
                    <label for="floatingMdpConfirm">Confirmation du mot de passe</label>
               </div>
               <div class="form-floating my-2">
                    <input type="date" name="date_naissance" class="form-control" id="floatingNaissance" placeholder="Date de naissance" required>
                    <label for="floatingNaissance">Date de naissance</label>
               </div>
               <div class="form-floating my-2">
                    <input type="text" name="ville_residence" class="form-control" id="adresse" list="suggestions" placeholder="Adresse" required>
                    <label for="adresse">Ville - Pays</label>
                    <datalist id="suggestions"></datalist>
               </div>
               <div class="d-grid gap-2">
                    <button class="btn btn-outline-success" type="submit">S'INSCRIRE</button>
                    <a class="btn btn-outline-secondary" href="Connexion.php" type="button">SE CONNECTER</a>
               </div>
          </form>
     </div>
     <div class="col">
     </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const input = document.getElementById("adresse");
        const datalist = document.getElementById("suggestions");

        input.addEventListener("input", () => {
            const query = input.value;

            if (query.length < 3) {
                datalist.innerHTML = "";
                return;
            }

            fetch(`https://geo.api.gouv.fr/communes?nom=${encodeURIComponent(query)}&fields=departement&boost=population&limit=5`)
                .then(response => response.json())
                .then(data => {
                    datalist.innerHTML = "";
                    data.forEach(commune => {
                        const option = document.createElement("option");
                        option.value = `${commune.nom} (${commune.code}) - ${commune.departement.nom}`;
                        datalist.appendChild(option);
                    });
                })
                .catch(error => console.error("Erreur lors de la récupération des données :", error));
        });
    });
</script>
<?php include 'Footer.php'; ?>