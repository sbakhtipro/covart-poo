<?php

namespace App\Database;

class QueryBuilder {

    public ?string $table = null;
    public ?string $select = null;
    public ?string $insertInto = null;
    public ?string $delete = null;
    public ?string $update = null;
    public ?string $from = null;
    public ?string $where = null;
    public ?string $joinOn = null;
    public ?array $bindings = [];

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

    public function insertInto(array $columns) {
        $sql = "INSERT INTO " . $this->table . " (";
        $columnsTable = array_keys($columns);
        $columnsStr = implode(", ", $columnsTable);
        $columnsBind = implode(", :", $columnsTable);
        $sql .= $columnsStr . ") VALUES (:" . $columnsBind . ")";
        foreach ($columns as $column => $value) {
            $this->bindings[$column] = $value;
        }
        $this->insertInto = $sql;
        return $this;
    }

    public function delete() {
        $sql = "DELETE";
        $this->delete = $sql;
        return $this;
    }

    public function update(array $columns) {
        $sql = "UPDATE " . $this->table . " SET ";
        $i = 0;
        foreach ($columns as $column => $value) {
            $sql .= $column . " = :" . $column;
            $i++;
            if ($i<count($columns)) {
                $sql .= ", ";
            }   
        }
        foreach ($columns as $column => $value) {
            $this->bindings[$column] = $value;
        }
        $this->update = $sql;
        return $this;
    }


    public function joinOn(array $joins) {
        $sql = "";
        foreach ($joins as $join) {
            $sql .= " JOIN " . $join['table'] . " ON " . $join['leftColumnTable'] . "." . $join['leftColumn'] . " = " . $join['rightColumnTable'] . "." . $join['rightColumn'];
        }
        $this->joinOn = $sql;
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
        foreach ($conditions as $condition) {
            if (isset($condition['table'])) {
                $sql .= $condition['table'] . ".";
            }
            $sql .= $condition['condition'] . " " . $condition['operator'] . " " . ":" . $condition['condition'];
            $i++;
            if ($i<count($conditions)) {
                $sql .= " AND ";
            }         
        }
        if (isset($condition)) {
            foreach ($conditions as $condition) {
                $this->bindings[$condition['condition']] = $condition['value'];
            }
        } 
        $this->where = $sql;
        return $this;
    }

    public function query() {
        $sql = $this->select . $this->insertInto . $this->delete . $this->update . $this->from . $this->joinOn . $this->where;
        var_dump($sql);
        // var_dump($this->bindings);
        // exit;
        $stmt = Database::getDb()->prepare($sql);
        $stmt->execute($this->bindings);
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        var_dump($data);
    }

}