<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title>Accueil - Covart</title>
    <!-- <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" /> -->
    <link rel="stylesheet" href="/css/style.css" />
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"> -->
    <!-- <script src="/js/choose-times.js"></script> -->
</head>

<body class="u-driver-theme">

    <!-- <script src="/js/forced-reload.js"></script> -->

    <main class="choose-times u-container-sm" id="main">
        <h1 class="choose-times__title">Choix des horaires</h1>

        <label for="identical-times" class="choose-times__identical-times-label">Horaires identiques :</label>
        <input type="time" id="identical-times" class="choose-times__identical-times-input">

        <form id="choose-times__form" autocomplete="off" action="/index.php?controller=propose-commute&method=save-step3-data" method="POST" class="choose-times__form">

            <fieldset class="choose-times__days-fieldset">
                <legend class="choose-times__days-legend">Horaires</legend>

                <?php foreach ($tableDays as $day) { ?>
                    <?php if (isset($day['already-proposed-commute'])) { ?>
                    <span class="choose-times__day-already-proposed"><?= escapeForHtml($day['day']); ?>
                        <span style="text-transform:lowercase"><?= escapeForHtml(($day['tomorrow']  === 'yes') ? ' (demain)' : '') ?></span>
                    </span>
                        <span><?= escapeForHtml($day['already-proposed-commute']) ?></span>
                    <?php }
                    else { ?>
                    <div class="choose-times__day-container">
                        <label class="choose-times__day-label">
                            <!-- <div class="choose-times__checkbox-container">
                                <svg class="choose-times__checkbox-svg" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" stroke-width="1.6" stroke="var(--color-primary)" clip-rule="evenodd" d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12ZM16.0303 8.96967C16.3232 9.26256 16.3232 9.73744 16.0303 10.0303L11.0303 15.0303C10.7374 15.3232 10.2626 15.3232 9.96967 15.0303L7.96967 13.0303C7.67678 12.7374 7.67678 12.2626 7.96967 11.9697C8.26256 11.6768 8.73744 11.6768 9.03033 11.9697L10.5 13.4393L12.7348 11.2045L14.9697 8.96967C15.2626 8.67678 15.7374 8.67678 16.0303 8.96967Z" fill="var(--color-primary)" />
                                </svg>
                            </div> -->
                            <input type="checkbox" value="<?= escapeForHtml($day['day']) . "_" . escapeForHtml($day['date']) ?>" name="dates[]" class="choose-times__day-input">
                            <?= escapeForHtml($day['day']); ?><span style="text-transform:lowercase"><?= escapeForHtml(($day['tomorrow']  === 'yes') ? ' (demain)' : '') ?></span>
                        </label>
                        <label>Départ :
                            <input type="time" class="choose-times__time-input" name="time-<?= escapeForHtml($day['day']) . "_" . escapeForHtml($day['date']) ?>">
                        </label>
                    </div>
                    <?php } ?>
                <?php } ?>

            </fieldset>
            <input type="hidden" value="<?= escapeForHtml($token) ?>" name="token-csrf">
            <input type="submit" value="Suivant" id="choose-times__submit" class="u-action u-action-primary" />
        </form>
    </main>
    <script src="/js/choose-times.js"></script>
    <script src="/js/main.js"></script>
</body>

</html>