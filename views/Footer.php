<footer class="d-flex flex-wrap justify-content-between align-items-center py-3 mt-4 border-top bg-dark fixed-bottom">
     <p class="col-md-4 mb-0 ps-5 text-light">&copy; 2025 AERO PORTAL</p>

     <a href="Acceuil.php" class="col-md-4 d-flex align-items-center justify-content-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
          <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" fill="#FFFFFF" class="bi bi-house" viewBox="0 0 16 16">
               <path d="M8.707 1.5a1 1 0 0 0-1.414 0L.646 8.146a.5.5 0 0 0 .708.708L2 8.207V13.5A1.5 1.5 0 0 0 3.5 15h9a1.5 1.5 0 0 0 1.5-1.5V8.207l.646.647a.5.5 0 0 0 .708-.708L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293zM13 7.207V13.5a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5V7.207l5-5z"/>
          </svg>
     </a>

     <ul class="nav col-md-4 justify-content-end align-items-center">
          <?php if (isset($_SESSION['utilisateur'])): ?>
               <li class="nav-item d-flex align-items-center me-3">
                    <span class="text-light">Connecté : <?= htmlspecialchars($_SESSION['utilisateur']['prenom']) ?></span>
                    <div class="spinner-grow text-success ms-3" style="width: 2rem; height: 2rem;" role="status">
                         <span class="visually-hidden"></span>
                    </div>
               </li>
          <?php else: ?>
               <li class="nav-item d-flex align-items-center me-3">
                    <div class="spinner-grow text-danger ms-3" style="width: 2rem; height: 2rem;" role="status">
                         <span class="visually-hidden"></span>
                    </div>
               </li>
          <?php endif; ?>
     </ul>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>