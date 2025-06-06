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
    <?php require_once ROOT . '/template/partials/_header.html.php' ?>    

    <main class="choose-address u-container-sm" id="main">
        <h1 class="choose-address__title">Choix de l'adresse</h1>
        <form action="/index.php?page=choose-times" method="POST" class="choose-address__form">
            <fieldset class="choose-address__type-fieldset">
                <legend class="choose-address__type-legend">Choisir le type de trajet :</legend>
                <?php foreach($commuteTypes as $type) { ?>
                    <label class="choose-address__type-label">
                        <input tabindex="0" class="choose-address__type-radio" type="radio" name="commute-type" id="<?= hsc($type['type_trajet_nom']) ?>" value="<?= hsc($type['type_trajet_nom']) ?>" required><?= hsc($type['type_trajet_nom']) ?>
                    </label>
                <?php } ?>
            </fieldset>
            <div class="choose-address__departure"></div>
            <div class="choose-address__arrival"></div>
            <input type="hidden" id="coordonnees-list" name="coordonnees-list" />
            <input type="hidden" id="coordonnees-input" name="coordonnees-input" />
            <input type="submit" value="Suivant" class="u-action u-action-primary"/>
        </form>

        <?php require_once ROOT . '/template/partials/_map.html.php'; ?>
    </main>
</body>
</html>
