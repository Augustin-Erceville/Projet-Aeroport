<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once '../../source/bdd/config.php';
require_once '../../source/model/VolsModel.php';
require_once '../../source/repository/VolsRepository.php';

$config = new Config();
$bdd = $config->connexion();
$volRepo = new VolsRepository($bdd);
if (!isset($_GET['id']) || empty($_GET['id'])) {
     $_SESSION['error'] = "ID du vol manquant pour la modification.";
     header('Location: VolsRead.php');
     exit();
}

$id = (int) $_GET['id'];
$vol = $volRepo->getVolById($id);

if (!$vol) {
     $_SESSION['error'] = "Vol introuvable.";
     header('Location: VolsRead.php');
     exit();
}
try {
     $stmt = $bdd->query("SELECT id_compagnie, nom FROM compagnies");
     $compagnies = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
     die("Erreur lors de la récupération des compagnies : " . $e->getMessage());
}
try {
     $stmt = $bdd->query("SELECT id_avion, immatriculation FROM avions");
     $avions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
     die("Erreur lors de la récupération des avions : " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
     <meta charset="UTF-8">
     <title>Modifier un Vol</title>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom bg-dark">
     <div class="col-2 ms-3 mb-2 mb-md-0 text-light">
          <a href="../Acceuil.php" class="d-inline-flex link-body-emphasis text-decoration-none">
               <img src="../../documentation/img/Logo.png" style="max-width: 15%; height: auto;">
               <div class="fs-4 text-light">AEROPORTAL</div>
          </a>
     </div>
     <ul class="nav col mb-2 justify-content-center mb-md-0">
          <li><a href="../Acceuil.php" class="nav-link px-2"><button type="button" class="btn btn-outline-info">Acceuil</button></a></li>
          <li><a href="../Avions/AvionsRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light active">Gestion avions</button></a></li>
          <li><a href="../Compagnies/CompagniesRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion compagnies</button></a></li>
          <li><a href="../Conges/CongesRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion congés</button></a></li>
          <li><a href="../Pilotes/PilotesRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion pilotes</button></a></li>
          <li><a href="../Reservations/ReservationsRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion réservations</button></a></li>
          <li><a href="../Utilisateurs/UtilisateursRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion utilisateurs</button></a></li>
          <li><a href="../Vols/VolsRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion vols</button></a></li>
     </ul>
     <div class="col-2 btn-group md-3 me-3 text-end" role="group" aria-label="Boutons utilisateur">
          <?php if (isset($_SESSION['utilisateur'])): ?>
               <a href="../../source/treatment/deconnexion.php" class="btn btn-outline-danger">DÉCONNEXION</a>
          <?php else: ?>
               <a href="Connexion.php" class="btn btn-outline-success">CONNEXION</a>
               <a href="Inscription.php" class="btn btn-outline-primary">INSCRIPTION</a>
          <?php endif; ?>
     </div>
</header>
<div class="container my-5">
     <h2 class="mb-4 text-center">Modifier le vol</h2>

     <?php if (isset($_SESSION['error'])): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($_SESSION['error']) ?></div>
          <?php unset($_SESSION['error']); ?>
     <?php endif; ?>

     <form method="post" action="../../source/treatment/VolsTreatment.php">
          <input type="hidden" name="action" value="update">
          <input type="hidden" name="id_vol" value="<?= htmlspecialchars($vol->getIdVol()) ?>">

          <div class="mb-3">
               <label for="numero_vol" class="form-label">Numéro du vol</label>
               <input type="text" class="form-control" id="numero_vol" name="numero_vol" value="<?= htmlspecialchars($vol->getNumeroVol()) ?>" required>
          </div>
          <div class="row">
               <div class="col mb-3">
                    <label for="ref_avion" class="form-label">Avion</label>
                    <select class="form-select" id="ref_avion" name="ref_avion" required>
                         <option value="" disabled>-- Sélectionner un avion --</option>
                         <?php foreach ($avions as $avion): ?>
                              <option value="<?= $avion['id_avion'] ?>" <?= ($vol->getRefAvion() == $avion['id_avion']) ? 'selected' : '' ?>>
                                   <?= htmlspecialchars($avion['immatriculation']) ?>
                              </option>
                         <?php endforeach; ?>
                    </select>
               </div>
               <div class="col mb-3">
                    <label for="ref_compagnie" class="form-label">Compagnie</label>
                    <select class="form-select" id="ref_compagnie" name="ref_compagnie" required>
                         <option value="" disabled>-- Sélectionner une compagnie --</option>
                         <?php foreach ($compagnies as $compagnie): ?>
                              <option value="<?= $compagnie['id_compagnie'] ?>" <?= ($vol->getRefCompagnie() == $compagnie['id_compagnie']) ? 'selected' : '' ?>>
                                   <?= htmlspecialchars($compagnie['nom']) ?>
                              </option>
                         <?php endforeach; ?>
                    </select>
               </div>
          </div>
          <div class="row">
               <div class="col mb-3">
                    <label for="aeroport_depart" class="form-label">Aéroport de départ</label>
                    <input type="text" class="form-control" id="aeroport_depart" name="aeroport_depart" value="<?= htmlspecialchars($vol->getAeroportDepart()) ?>" required>
               </div>
               <div class="col mb-3">
                    <label for="aeroport_arrivee" class="form-label">Aéroport d'arrivée</label>
                    <input type="text" class="form-control" id="aeroport_arrivee" name="aeroport_arrivee" value="<?= htmlspecialchars($vol->getAeroportArrivee()) ?>" required>
               </div>
          </div>
          <div class="row">
               <div class="col mb-3">
                    <label for="date_depart" class="form-label">Date et heure de départ</label>
                    <input type="datetime-local" class="form-control" id="date_depart" name="date_depart" value="<?= date('Y-m-d\TH:i', strtotime($vol->getDateDepart())) ?>" required>
               </div>
               <div class="col mb-3">
                    <label for="date_arrivee" class="form-label">Date et heure d'arrivée</label>
                    <input type="datetime-local" class="form-control" id="date_arrivee" name="date_arrivee" value="<?= date('Y-m-d\TH:i', strtotime($vol->getDateArrivee())) ?>" required>
               </div>
          </div>
          <div class="mb-3">
               <label for="prix" class="form-label">Prix (€)</label>
               <input type="number" step="0.01" class="form-control" id="prix" name="prix" value="<?= htmlspecialchars($vol->getPrix()) ?>" required>
          </div>

          <div class="mb-3">
               <label for="statut" class="form-label">Statut</label>
               <select class="form-select" id="statut" name="statut" required>
                    <?php
                    $statuts = ['prévu', 'en cours', 'retardé', 'annulé', 'terminé'];
                    foreach ($statuts as $statutOption) {
                         $selected = ($vol->getStatut() === $statutOption) ? 'selected' : '';
                         echo "<option value=\"$statutOption\" $selected>" . ucfirst($statutOption) . "</option>";
                    }
                    ?>
               </select>
          </div>

          <div class="d-grid gap-2">
               <button type="submit" class="btn btn-warning">Mettre à jour</button>
               <a href="VolsRead.php" class="btn btn-secondary">Annuler</a>
          </div>
     </form>
</div>
<?php include '../Footer.php'; ?>