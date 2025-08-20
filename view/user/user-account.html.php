<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mon compte</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body class="u-<?= escapeForHtml($_SESSION['role']) ?>-theme">

    <main class="account u-container-sm" id="main">
        <h1 class="account__title">Mon compte</h1>
        <ul class="account__profile-links">
            <li>
                <svg viewBox="0 0 52 52" xmlns="http://www.w3.org/2000/svg"><rect fill="none" height="4.8" rx="1.6" width="27.2" x="12.4" y="26"/><rect fill="none" height="4.8" rx="1.6" width="24" x="12.4" y="35.6"/><g>
                    <path d="m36.4 14.8h8.48a1.09 1.09 0 0 0 1.12-1.12 1 1 0 0 0 -.32-.8l-10.56-10.56a1 1 0 0 0 -.8-.32 1.09 1.09 0 0 0 -1.12 1.12v8.48a3.21 3.21 0 0 0 3.2 3.2z"/><path d="m44.4 19.6h-11.2a4.81 4.81 0 0 1 -4.8-4.8v-11.2a1.6 1.6 0 0 0 -1.6-1.6h-16a4.81 4.81 0 0 0 -4.8 4.8v38.4a4.81 4.81 0 0 0 4.8 4.8h30.4a4.81 4.81 0 0 0 4.8-4.8v-24a1.6 1.6 0 0 0 -1.6-1.6zm-32-1.6a1.62 1.62 0 0 1 1.6-1.55h6.55a1.56 1.56 0 0 1 1.57 1.55v1.59a1.63 1.63 0 0 1 -1.59 1.58h-6.53a1.55 1.55 0 0 1 -1.58-1.58zm24 20.77a1.6 1.6 0 0 1 -1.6 1.6h-20.8a1.6 1.6 0 0 1 -1.6-1.6v-1.57a1.6 1.6 0 0 1 1.6-1.6h20.8a1.6 1.6 0 0 1 1.6 1.6zm3.2-9.6a1.6 1.6 0 0 1 -1.6 1.63h-24a1.6 1.6 0 0 1 -1.6-1.6v-1.6a1.6 1.6 0 0 1 1.6-1.6h24a1.6 1.6 0 0 1 1.6 1.6z"/></g>
                </svg>
                <a href="/index.php?controller=personal-information&method=get-personal-information" class="account__profile-link">Modifier mes informations</a>
            </li>
            <li>
                <svg fill="#000000" version="1.1" id="Icons" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 32 32">
                    <path d="M28,13h1c0.6,0,1-0.4,1-1s-0.4-1-1-1h-2.8L25,8c-0.8-1.8-2.6-3-4.6-3h-8.7C9.6,5,7.8,6.2,7,8l-1.3,3H3c-0.6,0-1,0.4-1,1 s0.4,1,1,1h1c-1.2,0.9-2,2.4-2,4v4c0,0.9,0.4,1.7,1,2.2V25c0,1.7,1.3,3,3,3h2c1.7,0,3-1.3,3-3v-1h10v1c0,1.7,1.3,3,3,3h2 c1.7,0,3-1.3,3-3v-1.8c0.6-0.5,1-1.3,1-2.2v-4C30,15.4,29.2,13.9,28,13z M27,18c0,0.6-0.4,1-1,1h-3c-0.6,0-1-0.4-1-1s0.4-1,1-1h3 C26.6,17,27,17.4,27,18z M6,17h3c0.6,0,1,0.4,1,1s-0.4,1-1,1H6c-0.6,0-1-0.4-1-1S5.4,17,6,17z M10.4,22l1.2-2.3 c0.5-1,1.5-1.7,2.7-1.7h3.5c1.1,0,2.2,0.6,2.7,1.7l1.2,2.3H10.4z M8.9,8.8C9.4,7.7,10.4,7,11.6,7h8.7c1.2,0,2.3,0.7,2.8,1.8l1.4,3.2 h-17L8.9,8.8z"/>
                </svg>
                <a href="" class="account__profile-link">Mon véhicule</a>
            </li>
            <li>
                <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1.24264 8.24264L8 15L14.7574 8.24264C15.553 7.44699 16 6.36786 16 5.24264V5.05234C16 2.8143 14.1857 1 11.9477 1C10.7166 1 9.55233 1.55959 8.78331 2.52086L8 3.5L7.21669 2.52086C6.44767 1.55959 5.28338 1 4.05234 1C1.8143 1 0 2.8143 0 5.05234V5.24264C0 6.36786 0.44699 7.44699 1.24264 8.24264Z" fill="#000000"/>
                </svg>
                <a href="" class="account__profile-link">Mes préférences</a>
            </li>
            <li>
                <svg viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd" d="M8 16C12.4183 16 16 12.4183 16 8C16 3.58172 12.4183 0 8 0C3.58172 0 0 3.58172 0 8C0 12.4183 3.58172 16 8 16ZM7 3V8.41421L10.2929 11.7071L11.7071 10.2929L9 7.58579V3H7Z" fill="#000000"/>
                </svg>
                <a href="" class="account__profile-link">Historique des trajets</a>
            </li>
        </ul>
        <h2 class="account__legal-framework-title">Cadre légal</h2>
        <ul class="account__legal-framework-links">
            <li>
                <svg fill="#000000" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path d="M21.9,11.553l-3-6a.846.846,0,0,0-.164-.225A.987.987,0,0,0,18,5H13V3a1,1,0,0,0-2,0V5H6a.987.987,0,0,0-.731.328.846.846,0,0,0-.164.225l-3,6a.982.982,0,0,0-.1.447H2a4,4,0,0,0,8,0H9.99a.982.982,0,0,0-.1-.447L7.618,7H11V20H6a1,1,0,0,0,0,2H18a1,1,0,0,0,0-2H13V7h3.382l-2.277,4.553a.982.982,0,0,0-.1.447H14a4,4,0,0,0,8,0h-.01A.982.982,0,0,0,21.9,11.553ZM7.882,12H4.118L6,8.236Zm8.236,0L18,8.236,19.882,12Z"/></svg>
                <a href="" class="account__legal-framework-link">Mentions légales</a>
            </li>
            <li>
                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="System / Data">
                    <path id="Vector" d="M18 12V17C18 18.6569 15.3137 20 12 20C8.68629 20 6 18.6569 6 17V12M18 12V7M18 12C18 13.6569 15.3137 15 12 15C8.68629 15 6 13.6569 6 12M18 7C18 5.34315 15.3137 4 12 4C8.68629 4 6 5.34315 6 7M18 7C18 8.65685 15.3137 10 12 10C8.68629 10 6 8.65685 6 7M6 12V7" stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </g>
                </svg>
                <a href="" class="account__legal-framework-link">Protection des données</a>
            </li>
        </ul>
        <button class="account__delete-account-button">Supprimer mon compte</button>
    </main>
</body>
</html>