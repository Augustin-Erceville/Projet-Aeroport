<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title class="text-uppercase"><?= isset($pageTitle) ? $pageTitle . " • Aéroportal" : "Aéroportal" ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom bg-dark">
    <div class="col-2 ms-3 mb-2 mb-md-0 text-light">
        <a href="Acceuil.php" class="d-inline-flex link-body-emphasis text-decoration-none align-items-center">
            <img src="../documentation/img/Logo.png" style="max-width: 15%; height: auto;" alt="Logo Aéroportal">
            <div class="fs-4 text-light ms-2">AEROPORTAL</div>
        </a>
    </div>

    <ul class="nav col mb-2 justify-content-center mb-md-0">
        <?php
        $pages = [
            'Acceuil.php'        => 'Accueil',
            'AcheterBillet.php'  => 'Acheter un billet',
            'Enregistrement.php' => 'Enregistrement',
            'Reservation.php'    => 'Mes réservations',
            'Information.php'    => 'Informations',
            'Aide.php'           => 'Aide'
        ];

        foreach ($pages as $file => $label):
            $isActive = $currentPage === $file ? 'btn-outline-info active' : 'btn-outline-light';
            echo '<li><a href="'.$file.'" class="nav-link px-2">
                    <button type="button" class="btn '.$isActive.'">'.$label.'</button>
                  </a></li>';
        endforeach;

        if (isset($_SESSION['utilisateur'])):
            $isActiveAdmin = $currentPage === 'Administration.php' ? 'btn-outline-warning active' : 'btn-outline-warning';
            echo '<li><a href="Administration.php" class="nav-link px-2">
                    <button type="button" class="btn '.$isActiveAdmin.'">Administration</button>
                  </a></li>';
        endif;
        ?>
    </ul>

    <div class="col-2 btn-group md-3 me-3 text-end" role="group" aria-label="Boutons utilisateur">
        <?php if (isset($_SESSION['utilisateur'])): ?>
            <a href="../views/Account/AccountView.php" class="btn btn-outline-primary">MON COMPTE</a>
            <a href="../source/treatment/deconnexion.php" class="btn btn-outline-danger">DÉCONNEXION</a>
        <?php else:
            $isLoginActive = $currentPage === 'Connexion.php' ? 'btn-outline-success active' : 'btn-outline-success';
            $isRegisterActive = $currentPage === 'Inscription.php' ? 'btn-outline-primary active' : 'btn-outline-primary';
            ?>
            <a href="Connexion.php" class="btn <?= $isLoginActive ?>">CONNEXION</a>
            <a href="Inscription.php" class="btn <?= $isRegisterActive ?>">INSCRIPTION</a>
        <?php endif; ?>
    </div>
</header>
