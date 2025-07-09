<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <title>Accueil - Covart</title>
    <link rel="stylesheet" href="/css/style.css">
    <script src="/js/main.js" defer></script>
</head>

<body class="u-passenger-theme"> <!-- doit toujours avoir un thème-->
    <!-- div utilitaire noire utilisée pour recouvrir la fenêtre lors de l'ouverture d'une modale sur écran large -->
    <div class="u-overlay" aria-hidden="true"></div>
    <!-- déclaration des svg -->
    <svg xmlns="http://www.w3.org/2000/svg" class="u-svg">
        <symbol id="circle-in-circle" viewBox="0 0 16 16" fill="currentColor">
            <path d="M8 3a5 5 0 100 10A5 5 0 008 3z"/>
            <path fill-rule="evenodd" d="M0 8a8 8 0 1116 0A8 8 0 010 8zm8-6.5a6.5 6.5 0 100 13 6.5 6.5 0 000-13z" clip-rule="evenodd"/>
        </symbol>
    </svg>
    <svg version="1.1" id="Icons" xmlns="http://www.w3.org/2000/svg" class="u-svg" fill="currentColor" style="color:'var(--color-primary)'" >
        <symbol id="car-cancel-notification" viewBox="0 0 32 32" fill="currentColor">
            <path fill="#dc5846" d="M18.3,18.3c-3.1,3.1-3.1,8.2,0,11.3s8.2,3.1,11.3,0s3.1-8.2,0-11.3S21.5,15.2,18.3,18.3z M26.8,22.6L25.4,24l1.4,1.4
                c0.4,0.4,0.4,1,0,1.4c-0.4,0.4-1,0.4-1.4,0L24,25.4l-1.4,1.4c-0.4,0.4-1,0.4-1.4,0c-0.4-0.4-0.4-1,0-1.4l1.4-1.4l-1.4-1.4
                c-0.4-0.4-0.4-1,0-1.4c0.4-0.4,1-0.4,1.4,0l1.4,1.4l1.4-1.4c0.4-0.4,1-0.4,1.4,0C27.2,21.6,27.2,22.2,26.8,22.6z"/> 
            <path fill="currentColor" d="M8.4,22l1.2-2.3c0.5-1,1.5-1.7,2.7-1.7h3.5c0.1,0,0.2,0,0.2,0c1.8-2.4,4.7-4,8-4c1.2,0,2.3,0.2,3.4,0.6
                C27,14,26.5,13.4,26,13h1c0.6,0,1-0.4,1-1s-0.4-1-1-1h-2.8L23,8c-0.8-1.8-2.6-3-4.6-3H9.6C7.6,5,5.8,6.2,5,8l-1.3,3H1
                c-0.6,0-1,0.4-1,1s0.4,1,1,1h1c-1.2,0.9-2,2.4-2,4v4c0,0.9,0.4,1.7,1,2.2V25c0,1.7,1.3,3,3,3h2c1.7,0,3-1.3,3-3v-1h5
                c0-0.7,0.1-1.4,0.2-2H8.4z M7,19H4c-0.6,0-1-0.4-1-1s0.4-1,1-1h3c0.6,0,1,0.4,1,1S7.6,19,7,19z M5.5,12l1.4-3.2C7.4,7.7,8.4,7,9.6,7
                h8.7c1.2,0,2.3,0.7,2.8,1.8l1.4,3.2H5.5z"/>
        </symbol>
    </svg>
    <svg xmlns="http://www.w3.org/2000/svg"  class="u-svg" fill="currentColor">
        <symbol id="circle" viewBox="0 0 20 20">
            <circle cx="10" cy="10" r="8" stroke="currentColor" stroke-width="2"/>
        </symbol>
    </svg>

    <div class="home-page-layout u-container">

        <aside class="notifications">
            <button class="notifications__open-button u-open-modal-button" aria-controls="notifications-modal" aria-expanded="false" aria-label="Ouvrir les notifications - NOMBRE nouvelles notifications">Notifications</button>
            <div class="notifications__content u-modal" id="notifications-modal" role="dialog" aria-modal="true" aria-labelledby="notifications-title">
                <button class="notifications__close-modal-button u-close-modal-button">&#10006;</button>
                <span id="notifications-title" class="notifications__title">Notifications</span>
                <div class="notification">
                    <div class="notification__icon" aria-hidden="true">
                        <svg class="u-icon">
                            <use xlink:href="#car-cancel-notification"></use>
                        </svg>
                    </div>
                    <div class="notification__details">
                        <span class="notification__type">Prénom a accepté votre demande.<!-- type de notification --></span>
                        <span class="notification__schedules">Le 28.10.2025 à 08:35<!-- horaires concernées par la notification --></span>
                    </div>
                    <span class="notification__time">11:36<!-- heure de la notification --></span>
                </div>
            </div>
        </aside>      
    
        <main class="main">
            <h1>Espace passager</h1>
            <div class="main__links">
                <a href="index.php?controller=passenger-home&method=display-home&role=driver" class="main__switch u-driver-theme">Je suis conducteur</a>
                <a href="index.php?page=search-commute" class="main__search">Chercher un trajet</a>
                <a href="index.php?page=commute-requests" class="main__see-commute-requests">Voir mes demandes en cours -></a>
            </div>

            <section class="regular-drivers">
                <h2>Mes covoitureurs</h2>
                <div class="regular-drivers__container">
                    <article class="regular-drivers__driver">
                        <a href="#" class="regular-drivers__img u-img-wrapper">
                            <img src="img/user-image.png" alt="Photo de profil de PRENOM NOM">
                        </a>
                        <span>Ruzanna</span>
                    </article>
                </div>
            </section>

            <section class="commute-trips">
                <h2>Trajets</h2>
                <h3>Aujourd'hui</h3>
                <article class="commute-trip">
                    <div class="commute-trip__schedules">
                        <span class="commute-trip__time">08:15</span>
                        <div class="commute-trip__bar-wrapper" aria-hidden="true">
                            <svg width="16" height="16" class="u-icon"><use xlink:href="#circle-in-circle"></use></svg>
                            <div class="commute-trip__decoration"></div>
                            <svg width="16" height="16" class="u-icon">
                                <use xlink:href="#circle-in-circle"></use>
                            </svg>
                        </div>
                        <span class="commute-trip__time">08:30</span>
                        <label for="commute-trip-checkbox" class="commute-trip__checkbox-label">
                            <input type="checkbox" name="TYPE-commute-ID" id="commute-trip-checkbox" class="commute-trip__checkbox-input">
                        </label>
                    </div>
                    <div class="commute-trip__details">
                        <span><img src="img/icons/home.png" alt="Icône maison" class="u-icon" aria-hidden="true">Domicile</span>
                        <span><img src="img/icons/building-icon.svg" alt="Icône bâtiment" class="u-icon" aria-hidden="true">Travail</span>
                    </div>
                    <hr>
                    <div class="commute-trip__person">
                        <div class="commute-trip__img">
                            <img src="img/user-image.png" alt="Photo de profil de PRENOM NOM">
                        </div>
                        <div class="commute-trip__name-rating">
                            <span>Priscillia</span>
                            <span>5/5</span>
                        </div>
                    </div>
                    <!-- <button class="commute-trip__more-details-button u-open-modal-button" aria-label="Voir les détails du trajet ORIGINE DESTINATION le DATE à HEURE DE DEPART proposé par CONDUCTEUR" aria-controls="modal-ID-TRAJET-DEMANDE" aria-expanded="false"></button> -->
                    <div class="commute-trip__more-details-modal u-modal" id="modal-ID-TRAJET-DEMANDE" aria-modal="true" aria-label="Détails du trajet">
                        <button class="commute-trip__close-modal-button u-close-modal-button">&#10006;</button>
                    </div>
                </article>
            </section>
        </main>
    </div>
</body>
</html>