<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../../source/bdd/config.php';
require_once __DIR__ . '/../../source/model/AvionModel.php';
require_once __DIR__ . '/../../source/repository/AvionsRepository.php';

$config         = new Config();
$bdd            = $config->connexion();
$avionRepo      = new AvionsRepository($bdd);

if (!isset($_GET['id'])) {
    die('ID de l\'avion manquant.');
}

$id = intval($_GET['id']);
$avion = $avionRepo->getAvionById($id);

if (!$avion) {
    die('Avion non trouvé.');
}

$avionRepo->deleteAvion($id);

header('Location: AvionsRead.php?success=deleted');
exit;
