<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once '../../source/bdd/config.php';

$config = new Config();
$bdd = $config->connexion();

if (!isset($_GET['id']) || empty($_GET['id'])) {
     header('Location: AvionsRead.php');
     exit();
}

$id = (int)$_GET['id'];

try {
     $stmt = $bdd->prepare("SELECT * FROM avions WHERE id_avion = :id");
     $stmt->execute([':id' => $id]);
     $avion = $stmt->fetch(PDO::FETCH_ASSOC);

     if (!$avion) {
          header('Location: AvionsRead.php');
          exit();
     }

     $stmt = $bdd->query("SELECT id_compagnie, nom FROM compagnies");
     $compagnies = $stmt->fetchAll(PDO::FETCH_ASSOC);

} catch (PDOException $e) {
     die("Erreur lors de la récupération de l'avion : " . $e->getMessage());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
     $immatriculation = $_POST['immatriculation'] ?? '';
     $modele = $_POST['modele'] ?? '';
     $capacite = $_POST['capacite'] ?? '';
     $ref_compagnie = $_POST['ref_compagnie'] ?? null;

     if (!empty($immatriculation) && !empty($modele) && !empty($capacite) && !empty($ref_compagnie)) {
          try {
               $query = "UPDATE avions 
                      SET immatriculation = :immatriculation, modele = :modele, capacite = :capacite, ref_compagnie = :ref_compagnie
                      WHERE id_avion = :id";
               $stmt = $bdd->prepare($query);
               $stmt->execute([
                    ':immatriculation' => $immatriculation,
                    ':modele' => $modele,
                    ':capacite' => $capacite,
                    ':ref_compagnie' => $ref_compagnie,
                    ':id' => $id
               ]);

               header('Location: AvionsRead.php');
               exit();
          } catch (PDOException $e) {
               die("Erreur lors de la mise à jour de l'avion : " . $e->getMessage());
          }
     } else {
          $erreur = "Tous les champs sont obligatoires.";
     }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
     <meta charset="UTF-8">
     <title>Modifier un Avion</title>
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
<div class="container mt-5">
     <h2 class="mb-4 text-center">Modifier l'avion</h2>

     <?php if (!empty($erreur)): ?>
          <div class="alert alert-danger"><?= htmlspecialchars($erreur) ?></div>
     <?php endif; ?>

     <form method="post" action="">
          <div class="mb-3">
               <label for="immatriculation" class="form-label">Immatriculation</label>
               <input type="text" class="form-control" id="immatriculation" name="immatriculation" value="<?= htmlspecialchars($avion['immatriculation']) ?>" required>
          </div>

          <div class="mb-3">
               <label for="modele" class="form-label">Modèle</label>
               <input type="text" class="form-control" id="modele" name="modele" value="<?= htmlspecialchars($avion['modele']) ?>" required>
          </div>

          <div class="mb-3">
               <label for="capacite" class="form-label">Capacité</label>
               <input type="number" class="form-control" id="capacite" name="capacite" value="<?= htmlspecialchars($avion['capacite']) ?>" required>
          </div>

          <div class="mb-3">
               <label for="ref_compagnie" class="form-label">Compagnie</label>
               <select class="form-select" id="ref_compagnie" name="ref_compagnie" required>
                    <option value="" disabled>-- Sélectionner une compagnie --</option>
                    <?php foreach ($compagnies as $compagnie): ?>
                         <option value="<?= $compagnie['id_compagnie'] ?>" <?= $avion['ref_compagnie'] == $compagnie['id_compagnie'] ? 'selected' : '' ?>>
                              <?= htmlspecialchars($compagnie['nom']) ?>
                         </option>
                    <?php endforeach; ?>
               </select>
          </div>

          <div class="d-grid gap-2">
               <button type="submit" class="btn btn-success">Modifier</button>
               <a href="AvionsRead.php" class="btn btn-secondary">Annuler</a>
          </div>
     </form>
</div>

</body>
</html>
