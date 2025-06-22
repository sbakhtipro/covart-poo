<?php

namespace App\Router;

abstract class Router {

    public static function run() {
        if (empty($_GET)) {
            require ROOT . "/view/public/home.html.php";
            // return true;
        }
 
        else if (!isset($_GET["controller"]) || !isset($_GET["method"])) {
            require ROOT . "/view/public/404.html.php";
            // return false;
        }

        $controller = $_GET["controller"];
        $method = $_GET["method"];

        if ($controller === "user" && $method === "login") {
            $page = new \App\Controller\User();
            $page->login();
            return $page;
        }

        if ($controller === "driver-index" && $method === "home") {
            $page = new \App\Controller\Home();
            $page->home();
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