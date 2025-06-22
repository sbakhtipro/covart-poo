<?php

namespace App\Controller;

class User extends Controller {

    public $userModel = null;
    public $userAuth = null;

    public function __construct() {
        $this->userModel = new \App\Model\User();
        $this->userAuth = new \App\Auth\UserAuth();
    }

    public function login() {
        require_once ROOT . '/view/user/login.html.php';
        if (!empty($_POST['salarie_email']) && !empty($_POST['utilisateur_mdp'])) {
            $userCredentials = $this->userModel->getUserByCredentials($_POST['salarie_email']);
            if ($userCredentials) {
                $authenticate = $this->userAuth->login($userCredentials, $_POST['utilisateur_mdp']);
                if ($authenticate) {
                    if ($_SESSION['role'] === 'driver') {
                        if (!$this->isDriver()) {
                            $this->redirect("/index.php?controller=user&method=login");
                        }
                        else {
                            $this->redirect("/index.php?controller=" . $_SESSION['role'] . "-index&method=home");
                        } 
                    }
                }
                else {
                    echo 'Identifiants incorrects';
                }
            }
        }
    }

    public function logout() {
        session_unset();
        session_destroy();
        $this->redirect('/index.php?controller=user&method=login');
    }

    public function isAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
    }

    public function isPassenger() {
        return isset($_SESSION['role']) && isset($_SESSION['id']) && ($_SESSION['role'] === 'passenger' || $_SESSION['role'] === 'driver');
    }

    public function isDriver() {
        if (isset($_SESSION['role']) && isset($_SESSION['id']) && ($_SESSION['role'] === 'passenger' || $_SESSION['role'] === 'driver') && $_SESSION['permis_verifie'] === 0) {
            $this->redirect('/index.php?controller=license-verify');
        }
        return isset($_SESSION['role']) && isset($_SESSION['id']) && ($_SESSION['role'] === 'passenger' || $_SESSION['role'] === 'driver') && $_SESSION['permis_verifie'] === 1;
    }

}