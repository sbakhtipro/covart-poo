<?php

namespace App\Model;

// use App\Database\QueryBuilder;

class Agencies extends Model {

    public $addresses = [];

    public function getAllAddresses(): array {
        $addresses = $this->queryBuilder
            ->table('agences')
            ->select(['agence_numero_voie','agence_voie','agence_ville','agence_code_postal'])
            ->from()
            ->query();
        $this->addresses = $addresses;
        return $this->addresses;
    }

}