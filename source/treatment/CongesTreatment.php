<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../bdd/config.php';
require_once __DIR__ . '/../repository/CongesRepository.php';
require_once __DIR__ . '/../model/CongesModel.php';

$config = new Config();
$bdd = $config->connexion();
$congeRepo = new CongesRepository($bdd);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'create') {
        $conge = new CongesModel([
            'ref_pilote' => $_POST['ref_pilote'],
            'date_debut' => $_POST['date_debut'],
            'date_fin' => $_POST['date_fin'],
        ]);
        $congeRepo->createConge($conge);
        header('Location: ../../views/Conges/CongesRead.php');
        exit();
    }

    if ($action === 'update') {
        $conge = new CongesModel([
            'id_conge' => $_POST['id_conge'],
            'ref_pilote' => $_POST['ref_pilote'],
            'date_debut' => $_POST['date_debut'],
            'date_fin' => $_POST['date_fin'],
        ]);
        $congeRepo->updateConge($conge);
        header('Location: ../../views/Conges/CongesRead.php');
        exit();
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $congeRepo->deleteConge($id);
    header('Location: ../../views/Conges/CongesRead.php');
    exit();
}
