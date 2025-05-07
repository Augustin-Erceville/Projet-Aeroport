<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once '../bdd/config.php';
require_once '../model/PilotesModel.php';
require_once '../repository/PilotesRepository.php';

$config = new Config();
$bdd = $config->connexion();
$piloteRepo = new PilotesRepository($bdd);

$action = $_POST['action'] ?? $_GET['action'] ?? null;

if (!$action) {
     $_SESSION['error'] = "Action non définie.";
     header('Location: ../../views/Pilotes/PilotesRead.php');
     exit();
}

switch ($action) {
     case 'create':
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
               $pilote = new PiloteModel([
                    'ref_utilisateur' => $_POST['ref_utilisateur'] ?? null,
                    'ref_avion' => $_POST['ref_avion'] ?? null,
                    'disponible' => $_POST['disponible'] ?? 'Disponible'
               ]);

               try {
                    $piloteRepo->createPilote($pilote);
                    $_SESSION['success'] = "Pilote créé avec succès.";
               } catch (PDOException $e) {
                    $_SESSION['error'] = "Erreur lors de la création du pilote : " . $e->getMessage();
               }
          }
          break;

     case 'update':
          if ($_SERVER['REQUEST_METHOD'] === 'POST') {
               $pilote = new PiloteModel([
                    'id_pilote' => $_POST['id_pilote'] ?? null,
                    'ref_utilisateur' => $_POST['ref_utilisateur'] ?? null,
                    'ref_avion' => $_POST['ref_avion'] ?? null,
                    'disponible' => $_POST['disponible'] ?? 'Disponible'
               ]);

               try {
                    $piloteRepo->updatePilote($pilote);
                    $_SESSION['success'] = "Pilote modifié avec succès.";
               } catch (PDOException $e) {
                    $_SESSION['error'] = "Erreur lors de la modification du pilote : " . $e->getMessage();
               }
          }
          break;

     case 'delete':
          $id = $_GET['id'] ?? null;
          if ($id) {
               try {
                    $piloteRepo->deletePilote((int) $id);
                    $_SESSION['success'] = "Pilote supprimé avec succès.";
               } catch (PDOException $e) {
                    $_SESSION['error'] = "Erreur lors de la suppression du pilote : " . $e->getMessage();
               }
          } else {
               $_SESSION['error'] = "Identifiant du pilote non fourni.";
          }
          break;

     default:
          $_SESSION['error'] = "Action invalide.";
          break;
}

header('Location: ../../views/Pilotes/PilotesRead.php');
exit();
