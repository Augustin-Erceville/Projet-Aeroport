<?php session_start(); ?>
<?php include 'Header.php'; ?>

<div class="row">
    <div class="col">
    </div>
    <div class="col">
        <h4 class="text-center">INSCRIPTION</h4>
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
        <form action="../source/treatment/inscription.php" method="post" class="align-self-center">
            <div class="form-floating my-2">
                <input type="text" name="prenom" class="form-control" id="floatingPrenom" placeholder="Prénom" required>
                <label for="floatingPrenom">Prénom</label>
            </div>
            <div class="form-floating my-2">
                <input type="text" name="nom" class="form-control" id="floatingNom" placeholder="Nom de famille" required>
                <label for="floatingNom">Nom de famille</label>
            </div>
            <div class="form-floating my-2">
                <input type="tel" name="telephone" class="form-control" id="floatingTel" placeholder="Numéro de téléphone" required>
                <label for="floatingTel">Numéro de téléphone</label>
            </div>
            <div class="form-floating my-2">
                <input type="email" name="email" class="form-control" id="floatingEmail" placeholder="Adresse email" required>
                <label for="floatingEmail">Adresse email</label>
            </div>
            <div class="form-floating my-2">
                <input type="password" name="mot_de_passe" class="form-control" id="floatingMdp" placeholder="Mot de passe" required>
                <label for="floatingMdp">Mot de passe</label>
            </div>
            <div class="form-floating my-2">
                <input type="password" name="confirmation_mot_de_passe" class="form-control" id="floatingMdpConfirm" placeholder="Confirmation du mot de passe" required>
                <label for="floatingMdpConfirm">Confirmation du mot de passe</label>
            </div>
            <div class="form-floating my-2">
                <input type="date" name="date_naissance" class="form-control" id="floatingNaissance" placeholder="Date de naissance" required>
                <label for="floatingNaissance">Date de naissance</label>
            </div>
            <div class="form-floating my-2">
                <input type="text" name="ville_residence" class="form-control" id="adresse" list="suggestions" placeholder="Adresse" required>
                <label for="adresse">Ville - Pays</label>
                <datalist id="suggestions"></datalist>
            </div>
            <div class="d-grid gap-2">
                <button class="btn btn-outline-success" type="submit">S'INSCRIRE</button>
                <a class="btn btn-outline-secondary" href="Connexion.php" type="button">SE CONNECTER</a>
            </div>
        </form>
    </div>
    <div class="col">
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        const input = document.getElementById("adresse");
        const datalist = document.getElementById("suggestions");

        input.addEventListener("input", () => {
            const query = input.value;

            if (query.length < 3) {
                datalist.innerHTML = "";
                return;
            }

            fetch(`https://geo.api.gouv.fr/communes?nom=${encodeURIComponent(query)}&fields=departement&boost=population&limit=5`)
                .then(response => response.json())
                .then(data => {
                    datalist.innerHTML = "";
                    data.forEach(commune => {
                        const option = document.createElement("option");
                        option.value = `${commune.nom};
                        datalist.appendChild(option);
                    });
                })
                .catch(error => console.error("Erreur lors de la récupération des données :", error));
        });
    });
</script>
<?php include 'Footer.php'; ?>