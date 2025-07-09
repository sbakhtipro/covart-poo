<?php

namespace App\Model;

class ProposeCommute extends Model {

    public function getAllUserProposedCommutes($commuteType) {
        $recordset = $this->queryBuilder
            ->table('trajets_proposes')
            ->select(['trajet_heure_depart'])
            ->from()
            ->where('salarie_id', '=', $_SESSION['id'])
            ->where('trajet_suppression', '=', '0')
            ->where('type_trajet_id', '=', $commuteType)
            ->query();
        $proposedCommutes = [];
        if (is_array($recordset)) {
            foreach ($recordset as $row) {
                $proposedCommute = new \App\Entity\ProposedCommute();
                // $proposedCommute->setCommuteTypeId($row['type_trajet_id']);
                $proposedCommute->setDepartureTime($row['trajet_heure_depart']);
                array_push($proposedCommutes, $proposedCommute);
            }
        }
        return $proposedCommutes;
    }

    public function insertCommutesData() {
        $request = $this->queryBuilder
            ->table('proposed-commutes')
            ->query();
    }

}