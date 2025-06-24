<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil - NOM PRENOM</title>
    <link rel="stylesheet" href="../style.css">
</head>
<body class="u-passenger-theme">

    <main class="personal-information u-container-sm" id="main">
        <h1 class="personal-information">Mes informations</h1>
        <form action="" class="personal-information__form">
            <div class="personal-information__pp">
                <div class="personal-information__pp-img-wrapper u-img-wrapper">
                    <img src="../img/user-image.png" alt="">
                </div>
                <label for="profile-picture" class="personal-information__pp-label">
                    <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M13 5H9.32843C8.79799 5 8.28929 5.21071 7.91421 5.58579L7.08579 6.41421C6.71071 6.78929 6.20201 7 5.67157 7H4C2.89543 7 2 7.89543 2 9L2 19C2 20.1046 2.89543 21 4 21H18C19.1046 21 20 20.1046 20 19V12M17 5H23M20 8V2M11 18C13.2091 18 15 16.2091 15 14C15 11.7909 13.2091 10 11 10C8.79086 10 7 11.7909 7 14C7 16.2091 8.79086 18 11 18Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                    <input class="personal-information__pp-input" id="profile-picture" type="file">
                </label>
            </div>
            <label class="personal-information__label">
                Nom
                <input class="personal-information__input" type="text" name="salarie_nom" value="BAKHTI" disabled>
            </label>
            <label class="personal-information__label">
                Prénom
                <input class="personal-information__input" type="text" name="salarie_prenom"  value="Sarah" disabled>
            </label>
            <label class="personal-information__label">
                Date de naissance
                <input class="personal-information__input" type="date" name="salarie_date_naissance">
            </label>
            <label class="personal-information__label">
                Numéro de téléphone
                <input class="personal-information__input" type="text" name="salarie_numero_telephone"  value="06 36 40 43 73" disabled>
            </label>
            <label class="personal-information__label">
                Email
                <input class="personal-information__input" type="email" name="salarie_email" value="sarah.bxkhti@gmail.com" disabled>
            </label>
            <label class="personal-information__label">
                Adresse
                <input class="personal-information__input" type="text" name="salarie_adresse" value="7 rue de la Ronde" disabled> <!-- composée des colonnes numéro de voie et voie -->
            </label>
            <label class="personal-information__label">
                Ville
                <input class="personal-information__input" type="text" name="salarie_ville" value="METZ" disabled>
            </label>
            <label class="personal-information__label">
                Code postal
                <input class="personal-information__input" type="text" name="salarie_code_postal" value="57050" disabled>
            </label>
        </form>
    </main>
</body>
</html>