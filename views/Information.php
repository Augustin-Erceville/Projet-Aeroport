<?php if (session_status() === PHP_SESSION_NONE) session_start(); ?>
    <!doctype html>
    <html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>INFORMATION • AEROPORTAL</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    </head>
<body>
<header class="d-flex flex-wrap align-items-center justify-content-center justify-content-md-between py-3 mb-4 border-bottom bg-dark">
    <div class="col-2 ms-3 mb-2 mb-md-0 text-light">
        <a href="Acceuil.php" class="d-inline-flex link-body-emphasis text-decoration-none">
            <img src="../documentation/img/Logo.png" style="max-width: 15%; height: auto;">
            <div class="fs-4 text-light">AEROPORTAL</div>
        </a>
    </div>

    <ul class="nav col mb-2 justify-content-center mb-md-0">
        <li><a href="Acceuil.php" class="nav-link px-2"><button type="button" class="btn btn-outline-info">Accueil</button></a></li>
        <li><a href="AcheterBillet.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Acheter un billet</button></a></li>
        <li><a href="Enregistrement.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Enregistrement</button></a></li>
        <li><a href="Reservation.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Mes reservations</button></a></li>
        <li><a href="Information.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light active">Informations</button></a></li>
        <li><a href="Aide.php" class="nav-link px-2"><button type="button" class="btn btn-outline-light">Aide</button></a></li>
        <?php if (isset($_SESSION['utilisateur']) && $_SESSION['utilisateur']['role'] === 'Administrateur'): ?>
            <li><a href="Administration.php" class="nav-link px-2"><button type="button" class="btn btn-outline-warning">Administration</button></a></li>
        <?php endif; ?>
    </ul>

    <div class="col-2 btn-group md-3 me-3 text-end" role="group" aria-label="Boutons utilisateur">
        <?php if (isset($_SESSION['utilisateur'])): ?>
            <a href="../views/Account/AccountView.php" class="btn btn-outline-primary">MON COMPTE</a>
            <a href="../source/treatment/deconnexion.php" class="btn btn-outline-danger">DÉCONNEXION</a>
        <?php else: ?>
            <a href="Connexion.php" class="btn btn-outline-success">CONNEXION</a>
            <a href="Inscription.php" class="btn btn-outline-primary">INSCRIPTION</a>
        <?php endif; ?>
    </div>
</header>
<div class=" container">
    <div class="row">
        <h4 class="text-center text-uppercase">Informations utiles</h4>
        <div class="mb-4">
            <h3>🛫 À propos de notre aéroport</h3>
            <p>
                Bienvenue sur Aéroportal, le système de gestion simplifié pour votre expérience aéroportuaire.
                Que vous soyez passager, membre de l'équipage ou personnel de l'aéroport, cette plateforme vous
                permet de consulter, réserver et gérer vos vols en toute simplicité.
            </p>
        </div>

        <div class="mb-4">
            <h3>📅 Horaires et disponibilités</h3>
            <p>
                Les vols sont planifiés tous les jours de la semaine. Vous pouvez consulter les horaires directement
                depuis la section "Réservations" et acheter votre billet dans "Acheter un billet".
            </p>
            <p>
                Les pilotes et avions disponibles sont mis à jour en temps réel. La disponibilité des vols dépend
                des conditions météorologiques, du personnel et des plans de vol enregistrés.
            </p>
        </div>

        <div class="mb-4">
            <h3>👨‍✈️ Règlement pour les passagers</h3>
            <ul>
                <li>Présentez-vous au moins 30 minutes avant le départ pour l’enregistrement.</li>
                <li>Respectez les consignes de sécurité indiquées par le personnel de bord.</li>
                <li>Les objets interdits en cabine doivent être déclarés à l’avance.</li>
                <li>Un comportement respectueux est attendu tout au long de votre voyage.</li>
            </ul>
        </div>

        <div class="mb-4">
            <h3>📞 Contact et assistance</h3>
            <p>
                Pour toute question ou problème, vous pouvez nous contacter via la page "Aide", ou envoyer un mail à :
                <a href="mailto:support@aeroportal.com">support@aeroportal.com</a>
            </p>
        </div>
    </div>
</div>
<?php include 'Footer.php'; ?>