<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Accueil - Covart</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <link rel="stylesheet" href="/css/style.css" />
    <script src="/js/choose-address.js" defer></script>
</head>

<body class="u-driver-theme">

    <script src="/js/forced-reload.js"></script>

    <main class="choose-address u-container-sm" id="main">
        <h1 class="choose-address__title">Choix de l'adresse</h1>
        <form action="index.php?controller=propose-commute&method=save-step1-data" method="POST" class="choose-address__form" autocomplete="off">
            <fieldset class="choose-address__type-fieldset">
                <?php if ($availableTypes['aller'] === '0' && $availableTypes['retour'] === '0') { ?>
                    <p>Vous avez proposé le nombre maximal de trajets.</p>
                <?php }
                else { ?>
                    <legend class="choose-address__type-legend">Choisir le type de trajet :</legend>
                    <?php foreach($types as $type) { ?>
                        <label class="choose-address__type-label <?= $availableTypes[$type->getName()] === '1' ? '' : 'disabled' ?>">
                            <input tabindex="0" class="choose-address__type-radio" type="radio" name="commute-type" id="<?= $type->getName() ?>" value="<?= $type->getId() ?>" <?= $availableTypes[$type->getName()] === '1' ? 'required' : 'disabled' ?>><?= $type->getName(); ?>
                            <?php if ($availableTypes[$type->getName()] === '0') { ?>
                                <div class="choose-address__disabled-type-details">
                                    <button class="choose-address__disabled-type-button" type="button">
                                        <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg">
                                        <path fill="currentColor" d="M8,0 C12.4183,0 16,3.58173 16,8 C16,12.4183 12.4183,16 8,16 C3.58167,16 0,12.4183 0,8 C0,3.58173 3.58167,0 8,0 Z M8,2 C4.68628,2 2,4.68628 2,8 C2,11.3137 4.68628,14 8,14 C11.3137,14 14,11.3137 14,8 C14,4.68628 11.3137,2 8,2 Z M8,7 C8.51280357,7 8.93550255,7.38604429 8.99327177,7.88337975 L9,8 L9,11 C9,11.5523 8.55225,12 8,12 C7.48719643,12 7.06449745,11.613973 7.00672823,11.1166239 L7,11 L7,8 C7,7.44772 7.44775,7 8,7 Z M8,4 C8.55225,4 9,4.44772 9,5 C9,5.55228 8.55225,6 8,6 C7.44775,6 7,5.55228 7,5 C7,4.44772 7.44775,4 8,4 Z"/>
                                        </svg>
                                    </button>
                                    <span class="choose-address__disabled-type-span">Vous ne pouvez plus proposer de trajets de ce type.</span>
                                </div>
                            <?php } ?>
                        </label>
                    <?php }
                } ?>
            </fieldset>
            <div class="choose-address__departure"></div>
            <div class="choose-address__arrival"></div>
            <!-- <input type="hidden" id="coordonnees-list" name="coordonnees-list" />
            <input type="hidden" id="coordonnees-input" name="coordonnees-input" /> -->
            <input type="hidden" value="<?= escapeForHtml($token) ?>" name="token-csrf">
            <input type="submit" value="Suivant" id="submit" class="u-action u-action-primary" style="display: none;"/>
        </form>
        <!-- <script src="/js/autofill.js" defer></script> -->
    </main>
    <script src="/js/main.js"></script>
</body>
</html>
