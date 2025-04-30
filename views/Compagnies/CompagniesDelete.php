<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../../source/bdd/config.php';
require_once __DIR__ . '/../../source/model/CompagniesModel.php';
require_once __DIR__ . '/../../source/repository/CompagniesRepository.php';

$config        = new Config();
$bdd           = $config->connexion();
$compagnieRepo = new CompagniesRepository($bdd);

$id = isset($_GET['id']) ? (int) $_GET['id'] : null;
if ($id === null) {
    header('Location: CompagniesRead.php?error=missing_id');
    exit;
}

$compagnie = $compagnieRepo->getCompagnieById($id);
if (!$compagnie) {
    header('Location: CompagniesRead.php?error=notfound');
    exit;
}

$ok = $compagnieRepo->deleteCompagnie($id);

if ($ok) {
    header('Location: CompagniesRead.php?success=deleted');
} else {
    header('Location: CompagniesRead.php?error=delete_failed');
}
exit;
