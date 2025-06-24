<?php

namespace App\Model;

// use App\Database\QueryBuilder;

class Agencies extends Model {

    public $agencies = [];

    public function getAllAddresses() {
        $this->agencies = [];
        $recordset = $this->queryBuilder
            ->table('agences')
            ->select(['agence_numero_voie','agence_voie','agence_ville','agence_code_postal','agence_lat','agence_lon'])
            ->from()
            ->query();
        return $recordset;
    }
    
}