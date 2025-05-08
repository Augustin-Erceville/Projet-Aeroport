<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once '../../source/bdd/config.php';
require_once '../../source/repository/CongesRepository.php';

if (!isset($_GET['id'])) {
    header('Location: CongesRead.php');
    exit();
}

$config = new Config();
$bdd = $config->connexion();
$congeRepo = new CongesRepository($bdd);

$id = (int)$_GET['id'];
$conge = $congeRepo->getCongeById($id);

if (!$conge) {
    header('Location: CongesRead.php');
    exit();
}

$congeRepo->deleteConge($id);

header('Location: CongesRead.php');
exit();
