<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../../source/bdd/config.php';
require_once __DIR__ . '/../../source/repository/UtilisateursRepository.php';

$id = $_GET['id'] ?? null;

if ($id === null) {
    die("ID de l'utilisateur non spécifié.");
}

$config = new Config();
$bdd = $config->connexion();
$utilisateurRepo = new repository\UtilisateursRepository($bdd);

if ($utilisateurRepo->deleteUser((int)$id)) {
    header('Location: UtilisateursRead.php?success=suppression');
    exit;
} else {
    die("Échec de la suppression ou utilisateur introuvable.");
}
