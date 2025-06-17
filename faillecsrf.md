# Faille CSRF

Utile seulement si app multicompte avec différents rôles, même si espace admin séparé le hackeur devra à la fois trouver l'URL de l'admin ET le token

Token unique par utilisateur

Ex :

Utilisateurs : Arrive sur form connexion

Utilisateur 1  On crée une nouvelle variable de session $_SESSION['token'], delete.php?id=42&token=A -> id du produit, token de user

` ```if ($_GET['token'] == $_SESSION) {ok}`

Utilisateur 2 : On crée une nouvelle variable de session $_SESSION['token'], delete.php?id=42&token=B

Le token se met après la connexion

Si récupération du token par méthode POST -> input hidden avec token pour le récupérer en POST
