<?php session_start(); ?>
<?php include 'Header.php'; ?>
<main class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <h2 class="text-center mb-4">Connexion à votre compte</h2>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <?= $_SESSION['error']; unset($_SESSION['error']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <?= $_SESSION['success']; unset($_SESSION['success']); ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <form action="../source/treatment/connexion.php" method="post">
                <div class="form-floating mb-3">
                    <input type="email" name="email" class="form-control" id="floatingEmail" placeholder="Adresse email" required autocomplete="email">
                    <label for="floatingEmail">Adresse email</label>
                </div>
                <div class="form-floating mb-3">
                    <input type="password" name="mot_de_passe" class="form-control" id="floatingPassword" placeholder="Mot de passe" required autocomplete="current-password">
                    <label for="floatingPassword">Mot de passe</label>
                </div>
                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-outline-success">Se connecter</button>
                    <a href="Inscription.php" class="btn btn-outline-primary">Créer un compte</a>
                </div>
            </form>
        </div>
    </div>
</main>

<?php include 'Footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>