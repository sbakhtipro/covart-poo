<?php

// ajouter variable is_logged

namespace App\Controller;

class User extends Controller {

    public $userModel = null;
    public $userAuth = null;

    public function __construct() {
        $this->userModel = new \App\Model\User();
        $this->userAuth = new \App\Auth\UserAuth();
    }

    public function login() {
        $this->render('user/login');
        if (!empty($_POST['salarie_email']) && !empty($_POST['utilisateur_mdp'])) {
            $userCredentials = $this->userModel->getUserByCredentials($_POST['salarie_email']);
            if ($userCredentials) {
                $authenticate = $this->userAuth->login($userCredentials, $_POST['utilisateur_mdp']);
                if ($authenticate) {
                    if ($_SESSION['role'] === 'driver') {
                        if (!$this->userAuth->isDriver()) {
                            $this->redirect("/index.php?controller=user&method=login");
                        }
                        $this->redirect("/index.php?controller=" . $_SESSION['role'] . "-home&method=display-home");
                    }
                    else {
                        $this->redirect("/index.php?controller=" . $_SESSION['role'] . "-home&method=display-home");
                    } 
                }
                else {
                    echo 'Identifiants incorrects';
                }
            }
        }
    }

    public function firstLogin() {
        $this->render('user/first-login');
    }

    public function logout() {
        $_SESSION['role'] = '';
        $_SESSION['id'] = '';
        $_SESSION['permis_verifie'] = '';
        session_unset();
        session_destroy();
        $this->redirect('/index.php?controller=user&method=login');
    }

}