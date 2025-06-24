<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Accueil - Covart</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <link rel="stylesheet" href="/css/style.css" />
    <script src="/js/propose-commute.js" defer></script>
</head>

<body class="u-driver-theme">   

    <main class="choose-address u-container-sm" id="main">
        <h1 class="choose-address__title">Choix de l'adresse</h1>
        <form action="index.php?controller=proposed-commute&method=save-step1-data" method="POST" class="choose-address__form">
            <fieldset class="choose-address__type-fieldset">
                <legend class="choose-address__type-legend">Choisir le type de trajet :</legend>
                <?php foreach($types as $type) { ?>
                    <label class="choose-address__type-label">
                        <input tabindex="0" class="choose-address__type-radio" type="radio" name="commute-type" id="<?= $type->getName() ?>" value="<?= $type->getName() ?>" required><?= $type->getName() ?>
                    </label>
                <?php } ?>
            </fieldset>
            <div class="choose-address__departure"></div>
            <div class="choose-address__arrival"></div>
            <input type="hidden" id="coordonnees-list" name="coordonnees-list" />
            <input type="hidden" id="coordonnees-input" name="coordonnees-input" />
            <input type="submit" value="Suivant" id="submit" class="u-action u-action-primary" style="display: none;"/>
        </form>
        <!-- <script src="/js/autofill.js" defer></script> -->
    </main>
</body>
</html>
