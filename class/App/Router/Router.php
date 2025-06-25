<?php

// protection role dans router?

namespace App\Router;

abstract class Router {

    public static function run() {
        if (empty($_GET)) {
            require ROOT . "/view/public/home.html.php";
        }
 
        else if (!isset($_GET['controller']) || !isset($_GET['method'])) {
            require ROOT . '/view/public/404.html.php';
        }

        else if ($_GET['method'] !== 'login' && (empty($_SESSION['id']) || empty($_SESSION['role']))) {
            $page = new \App\Controller\User();
            $page->login();
            return $page;
        }

        $controller = $_GET['controller'];
        $method = $_GET['method'];

        if ($controller === 'user' && $method === 'login') {
            $page = new \App\Controller\User();
            $page->login();
            return $page;
        }

        if ($controller === 'user' && $method === 'logout') {
            $page = new \App\Controller\User();
            $page->logout();
            return $page;
        }

        if ($controller === 'driver-home' && $method === 'display-home') {
            $role = new \App\Auth\UserAuth();
            $role->isDriver();
            $page = new \App\Controller\Home();
            if (isset($_GET['role'])) {
                $page->switchRole($_GET['role']);
            }
            $page->displayHome($_SESSION['role'],$_SESSION['id']);
            return $page;
        }

        if ($controller === 'passenger-home' && $method === 'display-home') {
            $page = new \App\Controller\Home();
            if (isset($_GET['role'])) {
                $page->switchRole($_GET['role']);
            }
            $page->displayHome($_SESSION['role'],$_SESSION['id']);
            return $page;
        }

        if ($controller === 'license-verify' && $method === 'license-verify') {
            $page = new \App\Controller\LicenseVerify();
            $page->licenseVerify();
            return $page;
        }

        if ($controller === 'propose-commute' && $method === 'choose-address') {
            $page = new \App\Controller\ProposeCommute();
            $page->chooseAddress();
            return $page;
        }

        if ($controller === 'propose-commute' && $method === 'fetch-addresses') {
            $page = new \App\Controller\ProposeCommute();
            $page->fetchAddresses();
            return $page;
        }

        if ($controller === 'propose-commute' && $method === 'save-step1-data') {
            $page = new \App\Controller\ProposeCommute();
            $page->saveStep1Data();
            return $page;
        }

        if ($controller === 'propose-commute' && $method === 'choose-times') {
            $page = new \App\Controller\ProposeCommute();
            $page->chooseTimes();
            return $page;
        }

        if ($controller === 'propose-commute' && $method === 'save-step2-data') {
            $page = new \App\Controller\ProposeCommute();
            $page->saveStep2Data();
            return $page;
        }

        // if ($controller == "product" && $method == "listing")
        // return (new \App\Controller\Product())->listing();

        // if ($controller == "product" && $method == "detail" && isset($_GET["id"]))
        // return (new \App\Controller\Product())->detail($_GET["id"]);

        // if ($controller == "admin" && $method == "login")
        // return (new \App\Controller\Admin())->login();
    }

}