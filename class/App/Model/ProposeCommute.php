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

    public function insertCommutesData($data,$dateTime) {
        $request = $this->queryBuilder
            ->table('proposed-commutes')
            ->insertInto([
                'trajet_lieu_arrivee' => $data['arrival-address'],
                'trajet_lieu_arrivee_lat' => $data['arrival-coordinates']['lat'],
                'trajet_lieu_arrivee_lon' => $data['arrival-coordinates']['lon'],
                'trajet_lieu_depart' => $data['departure-address'],
                'trajet_lieu_depart_lat' => $data['departure-coordinates']['lat'],
                'trajet_lieu_depart_lon' => $data['departure-coordinates']['lon'],
                'trajet_heure_depart' => $dateTime,
                'trajet_nb_places' => $data['passengers-number'],
                'type_trajet_id' => $data['commute-type'],
                'salarie_id' => $_SESSION['id'],
                'vehicule_id' => ''
                ])
            ->where('salarie_id', '=', $_SESSION['id'])
            ->query();
    }

}