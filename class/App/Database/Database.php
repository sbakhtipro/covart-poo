<?php

namespace App\Database;

use PDO;
use PDOException;

class Database {

    private static $db;

    private string $host = HOST;
    private string $dbname = DBNAME;
    private string $charset = CHARSET;
    private string $username = USERNAME;
    private string $password = PASSWORD;

    public function connect() {
        try {
            $this->db = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname . ";charset=" . $this->charset, $this->username, $this->password);
        }
        catch (PDOException $e) {
            die;
        }
    }
    
    public function db() {
        if (self::$db === null) {
            $this->db = $this->connect();
        }
        return $this->db; 
    }
}