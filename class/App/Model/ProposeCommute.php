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
                'trajet_lieu_arrivee' => $data['form-step-1']['arrival-address'],
                'trajet_lieu_arrivee_lat' => $data['form-step-1']['arrival-coordinates']['lat'],
                'trajet_lieu_arrivee_lon' => $data['form-step-1']['arrival-coordinates']['lon'],
                'trajet_lieu_depart' => $data['form-step-1']['departure-address'],
                'trajet_lieu_depart_lat' => $data['form-step-1']['departure-coordinates']['lat'],
                'trajet_lieu_depart_lon' => $data['form-step-1']['departure-coordinates']['lon'],
                'trajet_date_heure_depart' => $dateTime,
                'trajet_nb_places' => $data['form-step-2']['passengers-number'],
                'type_trajet_id' => $data['form-step-1']['commute-type']['id'],
                'salarie_id' => $_SESSION['id'],
                'vehicule_id' => $data['form-step-2']['vehicle']
                ])
            // ->where('salarie_id', '=', $_SESSION['id'])
            ->query();
    }

}