<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Accueil - Covart</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" />
    <link rel="stylesheet" href="/css/style.css" />
    <script src="/js/choose-vehicle.js" defer></script>
</head>

<body class="u-driver-theme">

    <script src="/js/forced-reload.js"></script>

    <main class="choose-vehicle u-container-sm" id="main">
        <h1 class="choose-vehicle__title">Choix du véhicule</h1>
        <form action="index.php?controller=propose-commute&method=save-step2-data" method="POST" class="choose-vehicle__form">
            <label for="passengers-number">Nombre de passagers :</label>
            <select name="passengers_number" id="passengers-number">
                <option value="1">1 </option>
                <option value="2">2 </option>
                <option value="3">3 </option>
            </select>
            <label for="vehicle">Véhicule :</label>
            <select name="vehicle" id="vehicle">
                <?php foreach ($vehicles as $vehicle) { ?>
                    <option value="<?= $vehicle->getId() ?>"><?= $vehicle->getRegistrationPlate() ?></option>
                <?php } ?>
            </select>
            <input type="hidden" value="<?= escapeForHtml($token) ?>" name="token-csrf">
            <input type="submit" value="Suivant" id="submit" class="u-action u-action-primary"/>
        </form>
        <!-- <script src="/js/autofill.js" defer></script> -->
    </main>
    <script src="/js/main.js"></script>
</body>

</html>