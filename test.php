<?php

if ($_SERVER['REQUEST_METHOD'] === "POST") {
    if (isset($_POST['salarie_email']) && isset($_POST['utilisateur_mdp'])) {
        $stmt = $db->prepare(
            'SELECT 
                u.utilisateur_mdp,
                u.utilisateur_permis_verifie,
                s.salarie_id,
                r.role_nom
            FROM utilisateurs u
            JOIN salaries s ON s.salarie_id = u.salarie_id
            JOIN utilisateurs_roles ur ON ur.salarie_id = s.salarie_id
            JOIN roles r ON r.role_id = ur.role_id
            WHERE s.salarie_email = :salarie_email;'
        );
        $stmt->bindValue(':salarie_email', $_POST['salarie_email']);
        $stmt->execute();
       
        if ($row = $stmt->fetch()) {
             var_dump($row);
            if (password_verify($_POST['utilisateur_mdp'], $row['utilisateur_mdp'])) {
                session_regenerate_id(true);
                $_SESSION['role'] = $row['role_nom'];
                $_SESSION['permis_verifie'] = $row['utilisateur_permis_verifie'];
                $_SESSION['id'] = $row['salarie_id'];
                redirect("/index.php?page=" . $_SESSION['role'] . "-index");
            }
        }
    }
}
