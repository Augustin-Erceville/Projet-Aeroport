<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once '../bdd/config.php';
require_once '../model/VolsModel.php';
require_once '../repository/VolsRepository.php';

$config = new Config();
$bdd = $config->connexion();
$volRepo = new VolsRepository($bdd);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $action = $_POST['action'] ?? '';
     $id_vol = isset($_POST['id_vol']) ? (int) $_POST['id_vol'] : null;
     $numero_vol = trim($_POST['numero_vol'] ?? '');
     $ref_compagnie = (int) ($_POST['ref_compagnie'] ?? 0);
     $ref_avion = (int) ($_POST['ref_avion'] ?? 0);
     $aeroport_depart = trim($_POST['aeroport_depart'] ?? '');
     $aeroport_arrivee = trim($_POST['aeroport_arrivee'] ?? '');
     $date_depart = $_POST['date_depart'] ?? '';
     $date_arrivee = $_POST['date_arrivee'] ?? '';
     $prix = (float) ($_POST['prix'] ?? 0);
     $statut = $_POST['statut'] ?? 'prévu';

     if (empty($numero_vol) || empty($ref_compagnie) || empty($ref_avion) || empty($aeroport_depart) || empty($aeroport_arrivee) || empty($date_depart) || empty($date_arrivee)) {
          $_SESSION['error'] = "Tous les champs sont obligatoires.";
          header('Location: ../../views/Vols/VolsRead.php');
          exit();
     }

     try {
          if ($action === 'create') {
               $vol = new VolModel();
               $vol->setNumeroVol($numero_vol);
               $vol->setRefCompagnie($ref_compagnie);
               $vol->setRefAvion($ref_avion);
               $vol->setAeroportDepart($aeroport_depart);
               $vol->setAeroportArrivee($aeroport_arrivee);
               $vol->setDateDepart($date_depart);
               $vol->setDateArrivee($date_arrivee);
               $vol->setPrix($prix);
               $vol->setStatut($statut);

               $volRepo->createVol($vol);

               $_SESSION['success'] = "Vol ajouté avec succès.";
          }

          if ($action === 'update') {
               if (!$id_vol) {
                    throw new Exception("ID du vol non spécifié pour la mise à jour.");
               }

               $vol = new VolModel();
               $vol->setIdVol($id_vol);
               $vol->setNumeroVol($numero_vol);
               $vol->setRefCompagnie($ref_compagnie);
               $vol->setRefAvion($ref_avion);
               $vol->setAeroportDepart($aeroport_depart);
               $vol->setAeroportArrivee($aeroport_arrivee);
               $vol->setDateDepart($date_depart);
               $vol->setDateArrivee($date_arrivee);
               $vol->setPrix($prix);
               $vol->setStatut($statut);

               $volRepo->updateVol($vol);

               $_SESSION['success'] = "Vol mis à jour avec succès.";
          }

          header('Location: ../../views/Vols/VolsRead.php');
          exit();

     } catch (Exception $e) {
          $_SESSION['error'] = "Erreur : " . $e->getMessage();
          header('Location: ../../views/Vols/VolsRead.php');
          exit();
     }
}

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action']) && $_GET['action'] === 'delete') {
     $id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

     if ($id > 0) {
          try {
               $volRepo->deleteVol($id);
               $_SESSION['success'] = "Vol supprimé avec succès.";
          } catch (Exception $e) {
               $_SESSION['error'] = "Erreur lors de la suppression : " . $e->getMessage();
          }
     } else {
          $_SESSION['error'] = "ID de vol invalide.";
     }

     header('Location: ../../views/Vols/VolsRead.php');
     exit();
}
?>