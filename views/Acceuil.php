<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once '../source/bdd/config.php';
require_once '../source/model/VolsModel.php';
require_once '../source/repository/VolsRepository.php';

$config = new Config();
$bdd = $config->connexion();
$volRepo = new VolsRepository($bdd);

$prochainsVols = $volRepo->getNextFiveVols();
?>
<?php include 'Header.php'; ?>
<div class="container my-4">
    <div class="row">
        <h1 class="text-center text-uppercase mb-4">Bienvenue chez Aeroportal</h1>
    </div>
    <div class="row">
        <h2 class="text-center text-info mb-4">Prochains départs</h2>

        <?php if (!empty($prochainsVols)): ?>
            <?php foreach ($prochainsVols as $vol): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($vol->getNumeroVol()) ?></h5>
                            <p class="card-text">
                                <strong>Destination :</strong> <?= htmlspecialchars($vol->getAeroportArrivee()) ?><br>
                                <strong>Départ :</strong> <?= htmlspecialchars($vol->getDateDepart()) ?><br>
                                <strong>Compagnie :</strong> <?= htmlspecialchars($vol->getNomCompagnie()) ?>
                            </p>
                            <a href="AcheterBillet.php" class="btn btn-primary">Réserver</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center text-muted">Aucun vol disponible pour le moment.</p>
        <?php endif; ?>
    </div>
</div>

<?php include 'Footer.php'; ?>