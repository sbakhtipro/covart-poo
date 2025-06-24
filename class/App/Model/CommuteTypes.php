<?php

namespace App\Model;

class CommuteTypes extends Model {

    public function getCommuteTypes() {
        $recordset = $this->queryBuilder
            ->table('type_trajet')
            ->select(['type_trajet_id','type_trajet_nom'])
            ->from()
            ->query();
        $commuteTypes = [];
        if (is_array($recordset)) {
            foreach ($recordset as $row) {
                $commuteType = new \App\Entity\CommuteTypes();
                $commuteType->setId($row['type_trajet_id']);
                $commuteType->setName($row['type_trajet_nom']);
                array_push($commuteTypes,$commuteType);
            }
        }
        return $commuteTypes;
    }

}