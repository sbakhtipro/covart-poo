<?php

namespace App\Database;

use PDO;
use PDOException;

class Database {

    private static $db;

    private static string $host = HOST;
    private static string $dbname = DBNAME;
    private static string $charset = CHARSET;
    private static string $username = USERNAME;
    private static string $password = PASSWORD;

    private static function dbconnect() {
        try {
            self::$db = new PDO(
                "mysql:
                host=" . self::$host .
                ";dbname=" . self::$dbname .
                ";charset=" . self::$charset,
                self::$username,
                self::$password
            );
        }
        catch (PDOException $e) {
            $error = $e->getMessage();
            die;
        }
    }

    public static function getDb() {
        if (self::$db === null) {
            self::dbconnect();
        }
        return self::$db;
    }

}