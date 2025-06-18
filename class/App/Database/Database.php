<?php

namespace App\Database;

use PDO;
use PDOException;

class Database {

    public static $db;

    public static string $host = HOST;
    public static string $dbname = DBNAME;
    public static string $charset = CHARSET;
    public static string $username = USERNAME;
    public static string $password = PASSWORD;

    public static function dbconnect() {
        try {
            self::$db = new PDO(
                "mysql:
                host=" . self::$host .
                ";dbname=" . self::$dbname .
                ";charset=" . self::$charset,
                self::$username,
                self::$password
            );
            return self::$db;
        }
        catch (PDOException $e) {
            $error = $e->getMessage();
            die;
        }
    }

    public static function getDb() {
        if (self::$db === null) {
            self::$db = self::dbconnect();
        }
        return self::$db;
    }

}