<?php

namespace App;

class App {

    public static function init() {
        session_start();
        require_once "../config/config.php";
        require_once ROOT . "/helpers/helpers.php";
        self::autoloader();
    }

    public static function autoload($class) {
        require_once ROOT . "/class/" . str_replace("\\", DIRECTORY_SEPARATOR, $class) . ".php";
    }

    public static function autoloader() {
        spl_autoload_register([__CLASS__, 'autoload']);
    }

}