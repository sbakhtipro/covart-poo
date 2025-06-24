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

    <main class="choose-times u-container-sm" id="main">
        <h1 class="choose-times__title">Choix des horaires</h1>

        <div class="choose-times__addresses-summary">
            <div class="choose-times__departure-place">
                <span class="choose-times__place-label">Départ :</span>
                <?php if ($_SESSION['commute-type'] === 'aller') { ?>
                    <p><?= hsc($_SESSION['input-address']) ?></p>
                <?php } else { ?>
                    <p><?= hsc($_SESSION['list-address']) ?></p>
                <?php } ?>
            </div>
            <div class="choose-times__addresses-decoration"></div>
            <div class="choose-times__arrival-place">
                <span class="choose-times__place-label">Arrivée :</span>
                <?php if ($_SESSION['commute-type'] === 'aller') { ?>
                    <p><?= hsc($_SESSION['list-address']) ?></p>
                <?php } else { ?>
                    <p><?= hsc($_SESSION['input-address']) ?></p>
                <?php } ?>
            </div>
        </div>
        
        <form action="/index.php?page=choose-times" method="POST" class="choose-address__form">

            <fieldset class="choose-times__days-fieldset">
                <legend class="choose-times__days-legend">Horaires</legend>
                <?php          
                foreach ($tableDays as $day) { ?>
                    <fieldset class="choose-times__day-fieldset">
                        <legend class="choose-times__day-legend"><?= hsc($day['day']) ?></legend>
                        <label>
                            <input type="checkbox" value="<?= hsc($day['date']) ?>" name="dates[]">
                        </label>
                        <label>
                            Départ :
                            <input type="time">
                        </label>
                    </fieldset>
                <?php } ?>
            </fieldset>
                
            <input type="submit" value="Suivant" class="u-action u-action-primary"/>
        </form>
    </main>
</body>
</html>
