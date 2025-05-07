<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_GET['id']) || empty($_GET['id'])) {
     $_SESSION['error'] = "ID du vol manquant pour la suppression.";
     header('Location: VolsRead.php');
     exit();
}

$id = (int) $_GET['id'];
header("Location: ../../source/treatment/VolsTreatment.php?action=delete&id=" . $id);
exit();
?>
