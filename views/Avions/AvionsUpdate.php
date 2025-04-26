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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $type = $_POST['type'] ?? '';
    $capacite = $_POST['capacite'] ?? 0;

    $avion->setNom($nom);
    $avion->setType($type);
    $avion->setCapacite($capacite);

    $avionRepo->updateAvion($avion);

    header('Location: AvionsRead.php?success=updated');
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier un Avion</title>
</head>
<body>
<h1>Modifier un Avion</h1>

<form method="post">
    <label>Nom :</label><br>
    <input type="text" name="nom" value="<?= htmlspecialchars($avion->getNom()) ?>" required><br><br>

    <label>Type :</label><br>
    <input type="text" name="type" value="<?= htmlspecialchars($avion->getType()) ?>" required><br><br>

    <label>Capacité :</label><br>
    <input type="number" name="capacite" value="<?= htmlspecialchars($avion->getCapacite()) ?>" min="0" required><br><br>

    <button type="submit">Mettre à jour</button>
</form>

<br>
<a href="AvionsRead.php">Retour à la liste des avions</a>
</body>
</html>
