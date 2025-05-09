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
require_once __DIR__ . '/../source/repository/AdministrationRepository.php';

$config = new Config();
$bdd = $config->connexion();

$avionsRepo = new AvionsRepository($bdd);
$compagniesRepo = new CompagniesRepository($bdd);
$congesRepo = new CongesRepository($bdd);
$pilotesRepo = new PilotesRepository($bdd);
$reservationsRepo = new ReservationsRepository($bdd);
$utilisateursRepo = new UtilisateursRepository($bdd);
$volsRepo = new VolsRepository($bdd);
$adminRepo = new AdministrationRepository($bdd);

$nbAvions = count($avionsRepo->getAllAvions());
$nbCompagnies = count($compagniesRepo->getAllCompagnies());
$nbConges = count($congesRepo->getAllConges());
$nbPilotes = count($pilotesRepo->getAllPilotes());
$nbReservations = count($reservationsRepo->getAllReservations());
$nbUtilisateurs = count($utilisateursRepo->getAllUtilisateurs());
$nbVols = count($volsRepo->getAllVols());

function formatChartData(array $rows, string $labelKey, string $valueKey): array {
     return [
          'labels' => array_column($rows, $labelKey),
          'data' => array_column($rows, $valueKey)
     ];
}

$pie1 = formatChartData($adminRepo->getModeleAvions(), 'modele', 'total');
$pie2 = formatChartData($adminRepo->getDisponibilitePilotes(), 'disponibilite', 'total');
$pie3 = formatChartData($adminRepo->getStatutsVols(), 'statut', 'total');

$bar1 = formatChartData($adminRepo->getCapaciteParAvion(), 'id_avion', 'capacite');
$bar2 = formatChartData($adminRepo->getAvionsParCompagnie(), 'compagnie', 'total');
$bar3 = formatChartData($adminRepo->getCompagniesParPays(), 'pays', 'total');
$bar4 = formatChartData($adminRepo->getReservationsParVol(), 'ref_vol', 'total');
$bar5 = formatChartData($adminRepo->getReservationsParUtilisateur(), 'ref_utilisateur', 'total');
$bar6 = formatChartData($adminRepo->getClasseParReservation(), 'classe', 'total');
$bar7 = formatChartData($adminRepo->getStatutParReservation(), 'statut', 'total');
$bar8 = formatChartData($adminRepo->getUtilisateursParVille(), 'ville_residence', 'total');
$bar9 = formatChartData($adminRepo->getVolsParCompagnie(), 'compagnie', 'total');
$bar10 = formatChartData($adminRepo->getVolsParDestination(), 'destination', 'total');
?>
<!doctype html>
<html lang="fr">
<head>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <title>ADMINISTRATION • AEROPORTAL</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<header class="d-flex flex-wrap align-items-center justify-content-between py-3 mb-4 border-bottom bg-dark">
     <div class="col-2 ms-3 text-light">
          <a href="Acceuil.php" class="d-inline-flex text-decoration-none">
               <img src="../documentation/img/Logo.png" class="rounded-circle mx-3" style="max-width: 15%; height: auto;">
               <div class="fs-4 text-light">AEROPORTAL</div>
          </a>
     </div>
     <ul class="nav col justify-content-center">
          <li><a href="Acceuil.php" class="nav-link px-2"><button class="btn btn-outline-info">Accueil</button></a></li>
          <li><a href="Avions/AvionsRead.php" class="nav-link px-2"><button class="btn btn-outline-light">Avions</button></a></li>
          <li><a href="Compagnies/CompagniesRead.php" class="nav-link px-2"><button class="btn btn-outline-light">Compagnies</button></a></li>
          <li><a href="Conges/CongesRead.php" class="nav-link px-2"><button class="btn btn-outline-light">Congés</button></a></li>
          <li><a href="Pilotes/PilotesRead.php" class="nav-link px-2"><button class="btn btn-outline-light">Pilotes</button></a></li>
          <li><a href="Reservations/ReservationsRead.php" class="nav-link px-2"><button class="btn btn-outline-light">Réservations</button></a></li>
          <li><a href="Utilisateurs/UtilisateursRead.php" class="nav-link px-2"><button class="btn btn-outline-light">Utilisateurs</button></a></li>
          <li><a href="Vols/VolsRead.php" class="nav-link px-2"><button class="btn btn-outline-light">Vols</button></a></li>
     </ul>
     <div class="col-2 me-3 text-end">
          <?php if (isset($_SESSION['utilisateur'])): ?>
               <a href="../views/Account/AccountView.php" class="btn btn-outline-primary">Mon compte</a>
               <a href="../source/treatment/deconnexion.php" class="btn btn-outline-danger">Déconnexion</a>
          <?php else: ?>
               <a href="Connexion.php" class="btn btn-outline-success">Connexion</a>
               <a href="Inscription.php" class="btn btn-outline-primary">Inscription</a>
          <?php endif; ?>
     </div>
</header>
<div class="container my-5">
     <h4 class="text-center text-uppercase">Administration de Aeroportal</h4>
     <div class="row row-cols-1 row-cols-md-4 g-4 my-3">
          <?php foreach ([
                              ['Avions', $nbAvions, 'primary'],
                              ['Compagnies', $nbCompagnies, 'success'],
                              ['Congés', $nbConges, 'warning'],
                              ['Pilotes', $nbPilotes, 'danger'],
                              ['Réservations', $nbReservations, 'info'],
                              ['Utilisateurs', $nbUtilisateurs, 'secondary'],
                              ['Vols', $nbVols, 'dark']
                         ] as [$label, $count, $color]): ?>
               <div class="col">
                    <div class="card text-white bg-<?= $color ?> bg-gradient">
                         <div class="card-body text-center">
                              <h5 class="card-title"><?= $label ?></h5>
                              <p class="card-text fs-4"><?= $count ?></p>
                         </div>
                    </div>
               </div>
          <?php endforeach; ?>
     </div>
     <div class="row row-cols-1 row-cols-md-4 g-4 mt-4">
          <?php
          $titresGraphiques = [
               "Modèles des avions",
               "Disponibilité des pilotes",
               "Statuts des vols",
               "Vols par aéroport d'arrivée",
               "Capacité par avion",
               "Avions par compagnie",
               "Réservations par vol",
               "Réservations par utilisateur",
               "Classe par réservation",
               "Statut par réservation",
               "Utilisateurs par ville",
               "Vols par compagnie",
               "Compagnies par pays"
          ];
          ?>

          <?php for ($i = 1; $i <= 13; $i++): ?>
               <div class="col text-center">
                    <canvas id="<?= 'chart' . $i ?>"></canvas>
                    <div class="mt-2 fw-semibold"><?= $titresGraphiques[$i - 1] ?></div>
               </div>
          <?php endfor; ?>
     </div>
</div>
<hr>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const chartData = [
         <?= json_encode($pie1) ?>,
         <?= json_encode($pie2) ?>,
         <?= json_encode($pie3) ?>,
         <?= json_encode($bar10) ?>,
         <?= json_encode($bar1) ?>,
         <?= json_encode($bar2) ?>,
         <?= json_encode($bar4) ?>,
         <?= json_encode($bar5) ?>,
         <?= json_encode($bar6) ?>,
         <?= json_encode($bar7) ?>,
         <?= json_encode($bar8) ?>,
         <?= json_encode($bar9) ?>
    ];

    chartData.forEach((data, index) => {
        const ctx = document.getElementById('chart' + (index + 1));
        new Chart(ctx, {
            type: index < 4 ? 'pie' : 'bar',
            data: {
                labels: data.labels,
                datasets: [{
                    data: data.data,
                    backgroundColor: [
                        '#0d6efd', '#6610f2', '#6f42c1', '#d63384', '#dc3545',
                        '#fd7e14', '#ffc107', '#198754', '#20c997', '#0dcaf0'
                    ]
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    title: { display: false }
                },
                scales: index >= 4 ? {
                    y: { beginAtZero: true }
                } : {}
            }
        });
    });
</script>
<?php include 'Footer.php'; ?>