<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - NOM PRENOM</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="u-<?= hsc($_SESSION['role']) ?>-theme">
    <?php require_once ROOT . '/template/partials/_header.html.php' ?>

    <main class="profile u-container-sm" id="main">
        <div class="profile__links">
            <a href="#" class="profile__previous-page">
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M4 12H20M4 12L8 8M4 12L8 16" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
                Retour
            </a>
            <a href="#" class="profile__delete-regular-carpooler"></a>
        </div>
        <div class="profile__img u-img-wrapper">
            <img src="../img/user-image.png" alt="Photo de profil de PRENOM NOM">
        </div>
        <div class="profile__name-rating">
            <h1 class="profile__name">Prénom Nom</h1>
            <span class="profile__rating">5/5</span>
        </div>
        <p class="profile__description">Lorem ipsum dolor sit amet consectetur adipisicing elit. Similique ad, modi quia repellendus, tempore nobis veniam sequi inventore aut laboriosam excepturi accusantium voluptates minima voluptatibus aliquid magni magnam quas temporibus?</p>
        <!-- SI CONDUCTEUR AUSSI -->
        <span class="profile__vehicle">
            <svg fill="#000000" version="1.1" id="Icons" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                <path d="M28,13h1c0.6,0,1-0.4,1-1s-0.4-1-1-1h-2.8L25,8c-0.8-1.8-2.6-3-4.6-3h-8.7C9.6,5,7.8,6.2,7,8l-1.3,3H3c-0.6,0-1,0.4-1,1 s0.4,1,1,1h1c-1.2,0.9-2,2.4-2,4v4c0,0.9,0.4,1.7,1,2.2V25c0,1.7,1.3,3,3,3h2c1.7,0,3-1.3,3-3v-1h10v1c0,1.7,1.3,3,3,3h2 c1.7,0,3-1.3,3-3v-1.8c0.6-0.5,1-1.3,1-2.2v-4C30,15.4,29.2,13.9,28,13z M27,18c0,0.6-0.4,1-1,1h-3c-0.6,0-1-0.4-1-1s0.4-1,1-1h3 C26.6,17,27,17.4,27,18z M6,17h3c0.6,0,1,0.4,1,1s-0.4,1-1,1H6c-0.6,0-1-0.4-1-1S5.4,17,6,17z M10.4,22l1.2-2.3 c0.5-1,1.5-1.7,2.7-1.7h3.5c1.1,0,2.2,0.6,2.7,1.7l1.2,2.3H10.4z M8.9,8.8C9.4,7.7,10.4,7,11.6,7h8.7c1.2,0,2.3,0.7,2.8,1.8l1.4,3.2 h-17L8.9,8.8z"/>
            </svg>
            Peugeot 507 bleue
        </span>
        <span class="profile__driving-license">
            <svg fill="#000000" viewBox="0 0 14 14" role="img" focusable="false" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"><path fill="#000000" d="M4.2666667 5.73333l-.9333334.93334 3 3L13 3l-.933333-.93333L6.3333333 7.8 4.2666667 5.73333z"/><path d="M11.666667 11.66667H2.3333333V2.33333H9V1H2.3333333C1.6 1 1 1.6 1 2.33333v9.33334C1 12.4 1.6 13 2.3333333 13h9.3333337C12.4 13 13 12.4 13 11.66667V6.33333h-1.333333v5.33334z"/></svg>
            Permis vérifié
        </span>
        <!-- SI CONDUCTEUR -->
        <h2 class="profile__preferences-title">Préférences :</h2>
        <ul class="profile__preferences-list">
            <li class="preferences-list__preference">Non-fumeur</li>
            <li class="preferences-list__preference">Pas d'animaux</li>
            <li class="preferences-list__preference">Pas de musique</li>
            <li class="preferences-list__preference">Clim en été, chauffage en hiver</li>
        </ul>
    </main>
</body>
</html>