<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - NOM PRENOM</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body class="u-passenger-theme">
    <?php require_once ROOT . '/template/partials/_header.html.php' ?>

    <main class="preferences u-container-sm" id="main">
        <h1 class="preferences__title">Mes préférences</h1>
        <p class="preferences__p"> Vous êtes non-fumeur ou préférez ne pas voyager avec des animaux? Vous pouvez indiquer vos préférences ici.</p>
        <ul class="preferences__list">
            <li class="preferences__list-item">
                <span>Non-fumeur</span>
                <a href="">&#10006;</a>
            </li>
            <li class="preferences__list-item">
                <span>Pas d'animaux</span>
                <a href="">&#10006;</a>
            </li>
        </ul>
        <form action="" class="preferences__ajout-form">
            <select name="" id="">
                <option value="">Séléctionner une préférence</option>
                <option value="">Non-fumeur</option>
                <option value="">Pas d'animaux</option>
            </select>
            <input type="submit" value="Ajouter">
        </form>
    </main>
</body>
</html>