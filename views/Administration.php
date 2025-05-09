<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../source/bdd/config.php';
require_once __DIR__ . '/../source/repository/AvionsRepository.php';
require_once __DIR__ . '/../source/repository/CompagniesRepository.php';
require_once __DIR__ . '/../source/repository/CongesRepository.php';
require_once __DIR__ . '/../source/repository/PilotesRepository.php';
require_once __DIR__ . '/../source/repository/ReservationsRepository.php';
require_once __DIR__ . '/../source/repository/UtilisateursRepository.php';
require_once __DIR__ . '/../source/repository/VolsRepository.php';

$config = new Config();
$bdd = $config->connexion();

$avionsRepo = new AvionsRepository($bdd);
$compagniesRepo = new CompagniesRepository($bdd);
$congesRepo = new CongesRepository($bdd);
$pilotesRepo = new PilotesRepository($bdd);
$reservationsRepo = new ReservationsRepository($bdd);
$utilisateursRepo = new UtilisateursRepository($bdd);
$volsRepo = new VolsRepository($bdd);

$nbAvions = count($avionsRepo->getAllAvions());
$nbCompagnies = count($compagniesRepo->getAllCompagnies()) ;
$nbConges = count($congesRepo->getAllConges());
$nbPilotes = count($pilotesRepo->getAllPilotes());
$nbReservations = count($reservationsRepo->getAllReservations());
$nbUtilisateurs = count($utilisateursRepo->getAllUtilisateurs());
$nbVols = count($volsRepo->getAllVols());
?>
     <!doctype html>
     <html lang="fr">
     <head>
          <meta charset="utf-8">
          <meta name="viewport" content="width=device-width, initial-scale=1">
          <title>ADMINISTRATION • AEROPORTAL</title>
          <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
     </head>
<body>
<header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom bg-dark">
     <div class="col-2 ms-3 mb-2 mb-md-0 text-light">
          <a href="Acceuil.php" class="d-inline-flex link-body-emphasis text-decoration-none">
               <img src="../documentation/img/Logo.png" class="rounded-circle mx-3" style="max-width: 15%; height: auto;">
               <div class="fs-4 text-light">AEROPORTAL</div>
          </a>
     </div>
     <ul class="nav col mb-2 justify-content-center mb-md-0">
          <li><a href="Acceuil.php" class="nav-link px-2"><button type="button" class="btn btn-outline-info">Acceuil</button></a></li>
          <li><a href="Avions/AvionsRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion avions</button></a></li>
          <li><a href="Compagnies/CompagniesRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion compagnies</button></a></li>
          <li><a href="Conges/CongesRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion congés</button></a></li>
          <li><a href="Pilotes/PilotesRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion pilotes</button></a></li>
          <li><a href="Reservations/ReservationsRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion reservations</button></a></li>
          <li><a href="Utilisateurs/UtilisateursRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion utilisateurs</button></a></li>
          <li><a href="Vols/VolsRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion vols</button></a></li>
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
<div class="mx-3 my-3">
          <h4 class="text-center text-uppercase">Administration de Aeroportal</h4>
</div>
<div class="mx-3">
     <div class="row g-4">
          <div class="col mx-1">
               <div class="card text-white bg-primary bg-gradient">
                    <div class="card-body text-center">
                         <h5 class="card-title">Avions</h5>
                         <p class="card-text fs-4"><?= $nbAvions ?></p>
                    </div>
               </div>
          </div>
          <div class="col mx-1">
               <div class="card text-white bg-success bg-gradient">
                    <div class="card-body text-center">
                         <h5 class="card-title">Compagnies</h5>
                         <p class="card-text fs-4"><?= $nbCompagnies ?></p>
                    </div>
               </div>
          </div>
          <div class="col mx-1">
               <div class="card text-white bg-warning bg-gradient">
                    <div class="card-body text-center">
                         <h5 class="card-title">Congés</h5>
                         <p class="card-text fs-4"><?= $nbConges ?></p>
                    </div>
               </div>
          </div>
          <div class="col mx-1">
               <div class="card text-white bg-danger bg-gradient">
                    <div class="card-body text-center">
                         <h5 class="card-title">Pilotes</h5>
                         <p class="card-text fs-4"><?= $nbPilotes ?></p>
                    </div>
               </div>
          </div>
          <div class="col mx-1">
               <div class="card text-white bg-info bg-gradient">
                    <div class="card-body text-center">
                         <h5 class="card-title">Réservations</h5>
                         <p class="card-text fs-4"><?= $nbReservations ?></p>
                    </div>
               </div>
          </div>
          <div class="col mx-1">
               <div class="card text-white bg-secondary bg-gradient">
                    <div class="card-body text-center">
                         <h5 class="card-title">Utilisateurs</h5>
                         <p class="card-text fs-4"><?= $nbUtilisateurs ?></p>
                    </div>
               </div>
          </div>
          <div class="col mx-1">
               <div class="card text-white bg-dark bg-gradient">
                    <div class="card-body text-center">
                         <h5 class="card-title">Vols</h5>
                         <p class="card-text fs-4"><?= $nbVols ?></p>
                    </div>
               </div>
          </div>
     </div>
</div>
<div class="container my-5">
     <div class="row">
          <div class="col-md-6">
               <h5 class="text-center mb-3">Répartition des entités</h5>
               <canvas id="pieChart"></canvas>
          </div>
          <div class="col-md-6">
               <h5 class="text-center mb-3">Volume par entité</h5>
               <canvas id="barChart"></canvas>
          </div>
     </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const labels = ['Avions', 'Compagnies', 'Congés', 'Pilotes', 'Réservations', 'Utilisateurs', 'Vols'];
    const dataCounts = [<?= $nbAvions ?>, <?= $nbCompagnies ?>, <?= $nbConges ?>, <?= $nbPilotes ?>, <?= $nbReservations ?>, <?= $nbUtilisateurs ?>, <?= $nbVols ?>];

    new Chart(document.getElementById('pieChart'), {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: dataCounts,
                backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#0dcaf0', '#6c757d', '#212529']
            }]
        }
    });

    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: labels,
            datasets: [{
                label: 'Nombre d\'enregistrements',
                data: dataCounts,
                backgroundColor: '#0d6efd'
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
<?php include 'Footer.php'; ?>