<header class="header">
    <nav class="header__quick-access">
        <ul class="quick-access__list-items">
            <li class="quick-access__item"><a href="#nav" class="quick-access__link">Aller au menu</a></li>
            <li class="quick-access__item"><a href="#main" class="quick-access__link">Contenu principal</a></li>
            <li class="quick-access__item"><a href="#footer" class="quick-access__link">Pied de page</a></li>
        </ul>
    </nav>
    <nav class="header__nav" id="nav">
        <div class="nav__container u-container">
            <a href="" class="nav__logo">Covoit'</a>
            <button class="nav__burger is-closed" aria-expanded="false">
                <span class="nav__icon nav__burger-icon">&#9776;</span>
                <span class="nav__icon nav__close-icon">&#10006;</span>
            </button>
            <ul class="nav__links-list">
                <li class="nav__item"><a href="/index.php?page=<?= hsc($_SESSION['role']) ?>-index" class="nav__link">Accueil</a></li>
                <li class="nav__item"><a href="/index.php?page=user-account" class="nav__link">Mon compte</a></li>
                <li class="nav__item"><a href="/index.php?page=logout" class="nav__link">Déconnexion</a></li>
            </ul>
        </div>
    </nav>
</header>