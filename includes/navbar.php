<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
    <div class="container">

        <!-- Logo -->
        <a class="navbar-brand fw-bold" href="/GestMagasin/index.php">
            🛒 Gestion Marché
        </a>

        <!-- Bouton mobile -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Menu -->
        <div class="collapse navbar-collapse" id="menu">
            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link" href="/GestMagasin/index.php">Accueil</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/GestMagasin/produits/listes.php">Produits</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/GestMagasin/categorie/listes.php">Catégories</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="/GestMagasin/ventes/listes.php">Ventes</a>
                </li>

            </ul>

            <!-- Partie droite -->
            <div class="d-flex align-items-center text-white">

                <?php if(isset($_SESSION['user'])): ?>
                    <span class="me-3">
                        👤 <?php echo $_SESSION['user']['nom']; ?>
                    </span>

                    <a href="/GestMagasin/auth/logout.php" class="btn btn-danger btn-sm">
                        Déconnexion
                    </a>
                <?php else: ?>
                    <a href="/GestMagasin/auth/login.php" class="btn btn-primary btn-sm">
                        Connexion
                    </a>
                <?php endif; ?>

            </div>
        </div>
    </div>
</nav>