<?php

namespace App\Model;

abstract class Model {

    protected \Core\Database\QueryBuilder $queryBuilder;

    public function __construct() {
        $this->queryBuilder = new \Core\Database\QueryBuilder();
    }
    // protected static string $table;

    // protected static function create(array $data) {
    //     $keys = array_keys($data);
    //     $columns = implode(', ',$keys);
    //     $values = implode(', :',$keys);
    //     $sql = "INSERT INTO " . self::$table . " (" . $columns . ") VALUES (:" . $values . ")";
    //     $sql->execute($data);
    // }

    // protected static function readOne($id) {
    //     $sql = "SELECT * FROM " . self::$table . " WHERE :id=" .$id;
    // }

    // protected static function readAll() {
    //     $sql = "SELECT * FROM " . self::$table;
    // }

    // protected static function update() {
        
    // }

    // protected static function delete($id) {
    //     $sql = "DELETE FROM " .self::$table . " WHERE :id=" . $id;
    // }

}
