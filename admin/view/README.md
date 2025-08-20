# Excuses de dev

Projet permettant de générer des excuses choisies aléatoirement depuis une base de données réalisé dans le cadre d'un test.

## Technologies utilisées

- HTML
- CSS
- JS natif
- PHP
- JSON (pour la base de données)

## Structure du projet

### Dossier back :

- class ExportExcuse
- class ImportExcuse
- index servant de router
- Fichier JSON database

### Dossier components :

- Home - composant principal de la page d'accueil
- AddExcuseButton - bouton d'ajout d'excuses appelé dans Home
- Form - formulaire d'ajout d'excuse appelé dans Home
- GenerateExcuseButton - bouton de génération d'une excuse appelé dans Home
- Lost - composant principal de la page lost
- Error404 - composant principal de la page error

### Fichiers du dossier parent :

- .htaccess pour le fonctionnement des routes front
- index.html qui contient la div root dans laquelle sont affichées les pages
- router.js pour la gestion de l'affichage du front
- style.css

## Fonctionnalités et routes

### Front

- / : Page d'accueil, permet la génération aléatoire d’une excuse par le biais d'un bouton, contient un formulaire permettant d’ajouter une nouvelle excuse et affiché dans modale au clic sur le bouton d'ajout
- /lost : Page affichant GIF et redirection automatique après 5 secondes
- /* : Page 404
- Affichage responsif
- Requêtes asynchrones pour récupérer l'excuse et le GIF
- Contraste le plus bas à 5.56:1 respectant le niveau AA du WCAG

### Back

- Requête GET /index.php?action=get-excuse pour récupérer l'excuse, dans le cas où une excuse est déjà affichée la requête devient GET /index.php?action=get-excuse&actualExcuse=X afin de retourner une excuse différente
- Requête POST /index.php?action=insert-excuse pour ajouter une excuse à la database
- Réalisation du back en POO
- Serveur Apache configuré avec .htaccess pour rediriger toutes les requêtes vers index.html ce qui permet de gérer l'affichage avec les routes front

## Installation

1. Cloner le repository avec git clone https://github.com/sbakhtipro/excuses-de-dev
2. Ouvrir dans un serveur local (WAMP, LAMP, XAMPP)
3. Créer un virtualhost qui pointe sur le dossier excuses-de-dev et effectuer un redémarrer Apache (redémarrage DNS sur WAMP)
4. Se rendre sur l'URL excuses-de-dev/
