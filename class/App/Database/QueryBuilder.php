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
    public ?string $sql = '';

    /**
     * Définir la table sur laquelle on applique la requête initialement
     * @param string $table
     * @return self
     */
    public function table(string $table): self {
        $this->table = $table;
        return $this;
    }

    /**
     * Requête SELECT
     * @param string[]|null $columns  Colonnes dont on récupère les données (ex : [column 1, column 2])
     * @return self
     */
    public function select(?array $columns = null): self {
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

    /**
     * Requête INSERT INTO
     * @param array<string, mixed> $columns  Colonnes dans lesquelles on insère les valeurs (ex : ['column 1' => 'value', 'column 2' => 'value'])
     * @return self
     */
    public function insertInto(array $columns): self {
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

    /**
     * Requête DELETE
     * @return self
     */
    public function delete(): self {
        $sql = "DELETE";
        $this->delete = $sql;
        return $this;
    }

    /**
     * Requête UPDATE
     * @param array<string, mixed> $columns  Colonnes que l'on met à jour (ex : ['column 1' => 'value', 'column 2' => 'value'])
     * @return self
     */
    public function update(array $columns): self {
        $this->sql = "UPDATE " . $this->table . " SET ";
        $i = 0;
        foreach ($columns as $column => $value) {
            $this->sql .= $column . " = :" . $column;
            $i++;
            if ($i<count($columns)) {
                $this->sql .= ", ";
            }   
        }
        foreach ($columns as $column => $value) {
            $this->bindings[$column] = $value;
        }
        $this->update = $this->sql;
        return $this;
    }

    /**
     * Ajouter une jointure INNER JOIN
     * @param string $table             Table à joindre
     * @param string $leftColumnTable   Table de la colonne de gauche
     * @param string $leftColumn        Colonne de gauche
     * @param string $rightColumnTable  Table de la colonne de droite
     * @param string $rightColumn       Colonne de droite
     * @return self
     */
    public function joinOn($table, $leftColumnTable, $leftColumn, $rightColumnTable, $rightColumn): self {
        $sql = "";
        $sql .= " JOIN " . $table . " ON " . $leftColumnTable . "." . $leftColumn . " = " . $rightColumnTable . "." . $rightColumn;
        $this->joinOn .= $sql;
        return $this;
    }

    /**
     * Ajouter un FROM, se base sur la table déjà présente dans les propriétés de la classe
     * @return self
     */
    public function from(): self {
        $sql = " FROM " . $this->table;
        $this->from = $sql;
        return $this;
    }

    /**
     * Ajouter une condition WHERE
     * @param string $column      Colonne de la condition
     * @param string $operator    Opérateur
     * @param string $value       Valeur de la condition
     * @param string|null $table  Table où se situe la colonne
     * @return self
     */
    public function where($column, $operator, $value, $table = null): self {
        if ($this->where === null)  {
            $sql = " WHERE ";
        }
        else {
            $sql = " AND ";
        }
        if (isset($table)) {
            $sql .= $table . ".";
        }
        $sql .= $column . " " . $operator . " :" . $column;
        $this->bindings[$column] = $value;
        $this->where .= $sql;
        return $this;
    }

    /**
     * Rassemble les morceaux de requête et l'exécute
     * @return void
     */
    public function query(): array {
        $this->sql .= $this->select . $this->insertInto . $this->delete . $this->update . $this->from . $this->joinOn . $this->where;
        var_dump($this->sql);
        // var_dump($this->bindings);
        // exit;
        $stmt = Database::getDb()->prepare($this->sql);
        $stmt->execute($this->bindings);
        $data = $stmt->fetchAll(\PDO::FETCH_ASSOC);
        var_dump($data);
        return $data;
    }

}