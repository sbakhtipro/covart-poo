<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Accueil - Covart</title>
    <!-- <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine/dist/leaflet-routing-machine.css" /> -->
    <link rel="stylesheet" href="/css/style.css" />
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"> -->
    <!-- <script src="/js/choose-times.js"></script> -->
</head>

<body class="u-driver-theme">

    <main class="summary u-container-sm" id="main">
        <h1 class="summary__title">Résumé</h1>

        <section class="summary__addresses">
            <h2 class="addresses__title">Itinéraire</h2>
            <p class="addresses__item"><span class="addresses__item-title">Départ :</span> <?= escapeForHtml($data['departure-address']) ?></p>
            <p class="addresses__item"><span class="addresses__item-title">Arrivée :</span> <?= escapeForHtml($data['arrival-address']) ?></p>
        </section>

        <section class="summary__vehicle">
            <h2 class="vehicle__title">Véhicule</h2>
            <span class="vehicle__item"><span class="vehicle__item-title">Nombre de passagers :</span> <?= escapeForHtml($data['passengers-number']) ?></span>
            <span class="vehicle__item"><span class="vehicle__item-title">Véhicule :</span> <?= escapeForHtml($data['vehicle']) ?></span>
        </section>

        <section class="summary__times">
            <h2 class="times__title">Horaires</h2>
            <ul class="times__days">
                <?php foreach($data['commute-dates'] as $date) { ?>
                    <li class="times__day"><span class="times__day-span"><?= escapeForHtml($date['day']) ?></span>Départ à <?= escapeForHtml($date['time']) ?></li>
                <?php } ?>
            </ul>
        </section>

        <a href="index.php?controller=propose-commute&method=check-commutes-data" class="u-action u-action-primary">Publier</a>

    </main>
    <script src="/js/choose-times.js"></script>
</body>

</html>