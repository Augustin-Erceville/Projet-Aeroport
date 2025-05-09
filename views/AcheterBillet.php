<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once '../source/bdd/config.php';
require_once '../source/model/VolsModel.php';
require_once '../source/repository/VolsRepository.php';

$config = new Config();
$bdd = $config->connexion();
$volRepo = new VolsRepository($bdd);

$volsDisponibles = $volRepo->getAllVols();
?>
<?php include 'Header.php'; ?>

<div class="container my-4">
    <div class="row">
        <h4 class="text-center text-uppercase mb-4">Où souhaitez-vous aller ?</h4>
    </div>

    <div class="row">
        <?php if (!empty($volsDisponibles)): ?>
            <?php foreach ($volsDisponibles as $vol): ?>
                <div class="col-md-4 mb-4">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($vol->getNumeroVol()) ?></h5>
                            <p class="card-text">
                                <strong>Départ :</strong> <?= htmlspecialchars($vol->getAeroportDepart()) ?><br>
                                <strong>Arrivée :</strong> <?= htmlspecialchars($vol->getAeroportArrivee()) ?><br>
                                <strong>Date de départ :</strong> <?= htmlspecialchars($vol->getDateDepart()) ?><br>
                                <strong>Prix :</strong> <?= htmlspecialchars(number_format($vol->getPrix(), 2)) ?> €
                            </p>
                            <a href="#" class="btn btn-primary">Acheter ce billet</a>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoIIfJcLyjU29tka7Sk3YSA8l7IgGKmFckcImFV8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>
