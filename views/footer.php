<footer class="d-flex flex-wrap justify-content-between align-items-center py-3 mt-4 border-top bg-dark fixed-bottom">
     <p class="col-md-4 mb-0 ps-5 text-light">&copy; 2025 AERO PORTAL</p>

     <a href="acceuil.php" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
          <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#FFFFFF" class="bi bi-send-fill" viewBox="0 0 16 16">
               <path d="M15.964.686a.5.5 0 0 0-.65-.65L.767 5.855H.766l-.452.18a.5.5 0 0 0-.082.887l.41.26.001.002 4.995 3.178 3.178 4.995.002.002.26.41a.5.5 0 0 0 .886-.083zm-1.833 1.89L6.637 10.07l-.215-.338a.5.5 0 0 0-.154-.154l-.338-.215 7.494-7.494 1.178-.471z"/>
          </svg>
     </a>

     <ul class="nav col-md-4 justify-content-end align-items-center">
          <?php if (isset($_SESSION['utilisateur'])): ?>
               <li class="nav-item d-flex align-items-center me-3">
                    <div class="spinner-grow text-success me-3" style="width: 2rem; height: 2rem;" role="status">
                         <span class="visually-hidden">Loading...</span>
                    </div>

                    <span class="text-light">Connecté : <?= htmlspecialchars($_SESSION['utilisateur']['prenom']) ?></span>
               </li>
          <?php endif; ?>
          <li class="nav-item"><a href="acceuil.php" class="nav-link px-2 text-light">Acceuil</a></li>
          <li class="nav-item"><a href="acheter_billet.php" class="nav-link px-2 text-light">Réserver</a></li>
          <li class="nav-item"><a href="#" class="nav-link px-2 text-light">CGU</a></li>
          <li class="nav-item"><a href="#" class="nav-link px-2 text-light">CGV</a></li>
          <li class="nav-item"><a href="#" class="nav-link px-2 text-light">A propos</a></li>
     </ul>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
