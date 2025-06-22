<?php

namespace App\Auth;

class UserAuth {

    public function login($userInformations, $inputPassword): bool {
        if (password_verify($inputPassword, $userInformations['utilisateur_mdp'])) {
            session_regenerate_id(true);
            $_SESSION['role'] = $userInformations['role_nom'];
            $_SESSION['permis_verifie'] = $userInformations['utilisateur_permis_verifie'];
            $_SESSION['id'] = $userInformations['salarie_id'];
            return true;
        }
        return false;
    }

}