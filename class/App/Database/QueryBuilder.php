<?php

// requetes : select, insert, delete, update
// join
// and

namespace App\Database;

class QueryBuilder {

    public ?string $table = null;
    public ?string $select = null;
    public ?string $from = null;
    public ?string $where = null;
    public ?array $bindings = null;

    public function table(string $table) {
        $this->table = $table;
        return $this;
    }

    public function select(?array $columns = null) {
        if (!$columns) {
            $sql = "SELECT *";
        }
        else {
            $columnsStr = implode(", ",$columns);
            $sql = "SELECT " . $columnsStr;
        }
        $this->select = $sql;
        return $this;
    }

    public function from() {
        $sql = " FROM " . $this->table;
        $this->from = $sql;
        return $this;
    }

    public function where(array $conditions) {
        $sql = " WHERE ";
        $i = 0;
        foreach ($conditions as $condition => $value) {
            $i++;
            // bindValue!
            $sql .= $condition . "=:" . $condition;
            if ($i<count($conditions)) {
                $sql .= " AND ";
            }         
        }     
        $this->where = $sql;
        return $this;
    }

    public function query() {
        $db = \App\Database\Database::getDb();
        $sql = $this->select . $this->from . $this->where;
        var_dump($sql);
    }

}

$query = new QueryBuilder();
$query
    ->table('product')
    ->select()
    ->from()
    ->where([
        'test-column1' => 'test-value1',
        'test-column2' => 'test-value2'
        ])
    ->query();