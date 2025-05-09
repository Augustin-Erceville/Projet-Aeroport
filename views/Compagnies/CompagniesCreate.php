<?php
if (session_status() === PHP_SESSION_NONE) session_start();

require_once __DIR__ . '/../../source/bdd/config.php';
require_once __DIR__ . '/../../source/model/CompagniesModel.php';
require_once __DIR__ . '/../../source/repository/CompagniesRepository.php';

$config        = new Config();
$bdd           = $config->connexion();
$compagnieRepo = new CompagniesRepository($bdd);
$message       = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom  = trim($_POST['nom']  ?? '');
    $pays = trim($_POST['pays'] ?? '');

    if ($nom !== '' && $pays !== '') {
        $compagnie = new CompagnieModel(null, $nom, $pays, '');
        $compagnieRepo->createCompagnie($compagnie);
        header('Location: CompagniesRead.php?success=1');
        exit;
    } else {
        $message = 'Tous les champs sont obligatoires.';
    }
}
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>COMPAGNIES • ADMIN • AEROPORTAL</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        window.addEventListener('DOMContentLoaded', async () => {
            const selectPays = document.getElementById('pays');
            try {
                const resp = await fetch('https://restcountries.com/v3.1/all');
                const data = await resp.json();
                const paysList = data
                    .map(c => c.translations?.fra?.common || c.name.common)
                    .sort((a, b) => a.localeCompare(b));
                selectPays.innerHTML = '<option value="">Sélectionner un pays</option>';
                for (const p of paysList) {
                    const opt = document.createElement('option');
                    opt.value = p;
                    opt.textContent = p;
                    selectPays.append(opt);
                }
            } catch (e) {
                console.error('Erreur chargement pays:', e);
                selectPays.innerHTML = '<option value="">Erreur de chargement</option>';
            }
        });
    </script>
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
        <li><a href="../Avions/AvionsRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion avions</button></a></li>
        <li><a href="../Compagnies/CompagniesRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light active">Gestion compagnies</button></a></li>
        <li><a href="../Conges/CongesRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion congés</button></a></li>
        <li><a href="../Pilotes/PilotesRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion pilotes</button></a></li>
        <li><a href="../Reservations/ReservationsRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion réservations</button></a></li>
        <li><a href="../Utilisateurs/UtilisateursRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion utilisateurs</button></a></li>
        <li><a href="../Vols/VolsRead.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Gestion vols</button></a></li>
    </ul>
    <div class="col-2 btn-group md-3 me-3 text-end" role="group" aria-label="Boutons utilisateur">
        <?php if (isset($_SESSION['utilisateur'])): ?>
            <a href="../../views/Account/AccountView.php" class="btn btn-outline-primary">MON COMPTE</a>
            <a href="../../source/treatment/deconnexion.php" class="btn btn-outline-danger">DÉCONNEXION</a>
        <?php else: ?>
            <a href="../Connexion.php" class="btn btn-outline-success">CONNEXION</a>
            <a href="../Inscription.php" class="btn btn-outline-primary">INSCRIPTION</a>
        <?php endif; ?>
    </div>
</header>
<div class="container mt-5">
    <h3 class="mb-4">Ajouter une nouvelle compagnie</h3>

    <?php if ($message): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($message) ?></div>
    <?php endif; ?>

    <form method="post" class="row g-3">
            <label for="nom" class="form-label">Nom de la compagnie</label>
            <input type="text" id="nom" name="nom" class="form-control" required value="<?= htmlspecialchars($_POST['nom'] ?? '') ?>">
            <label for="pays" class="form-label">Pays d'origine</label>
            <select id="pays" name="pays" class="form-select" required>
                <option value="">Chargement...</option>
            </select>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Ajouter la compagnie</button>
        </div>
    </form>
</div>
</body>
</html>
