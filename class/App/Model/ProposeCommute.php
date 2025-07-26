<?php

namespace App\Model;

class ProposeCommute extends Model {

    public function getAllUserProposedCommutes($commuteType) {
        $recordset = $this->queryBuilder
            ->table('trajets_proposes')
            ->select(['trajet_date_heure_depart'])
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
                $proposedCommute->setDepartureTime($row['trajet_date_heure_depart']);
                array_push($proposedCommutes, $proposedCommute);
            }
        }
        return $proposedCommutes;
    }

    public function insertCommutesData($data,$dateTime) {
        $request = $this->queryBuilder
            ->table('trajets_proposes')
            ->insertInto([
                'trajet_lieu_arrivee' => $data['propose-commute-step-1']['trajet_lieu_arrivee'],
                'trajet_lieu_arrivee_lat' => $data['propose-commute-step-1']['trajet_lieu_arrivee_lat'],
                'trajet_lieu_arrivee_lon' => $data['propose-commute-step-1']['trajet_lieu_arrivee_lon'],
                'trajet_lieu_depart' => $data['propose-commute-step-1']['trajet_lieu_depart'],
                'trajet_lieu_depart_lat' => $data['propose-commute-step-1']['trajet_lieu_depart_lat'],
                'trajet_lieu_depart_lon' => $data['propose-commute-step-1']['trajet_lieu_depart_lon'],
                'trajet_date_heure_depart' => $dateTime,
                'trajet_nb_places' => $data['propose-commute-step-2']['trajet_nb_places'],
                'type_trajet_id' => $data['propose-commute-step-1']['type_trajet_id'],
                'salarie_id' => $_SESSION['id'],
                'vehicule_id' => $data['propose-commute-step-2']['vehicule_id']
                ])
            ->query();
    }

}