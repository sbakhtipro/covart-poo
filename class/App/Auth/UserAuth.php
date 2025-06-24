<?php

namespace App\Auth;

class UserAuth extends Auth {

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

    public function isAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    public function isPassenger() {
        return isset($_SESSION['role']) && isset($_SESSION['id']) && ($_SESSION['role'] === 'passenger' || $_SESSION['role'] === 'driver');
    }

    public function isDriver() {
        if (isset($_SESSION['role']) && isset($_SESSION['id']) && ($_SESSION['role'] === 'passenger' || $_SESSION['role'] === 'driver') && $_SESSION['permis_verifie'] === 0) {
            // $this->redirect('/index.php?controller=license-verify');
            $this->redirect('/index.php?controller=license-verify&method=license-verify');
        }
        return isset($_SESSION['role']) && isset($_SESSION['id']) && ($_SESSION['role'] === 'passenger' || $_SESSION['role'] === 'driver') && $_SESSION['permis_verifie'] === 1;
    }

   

}