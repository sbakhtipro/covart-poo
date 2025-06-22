<?php

namespace App\Model;

class PlannedCommute extends Model {

    public function getInformations($userRole,$userId) {
        $data = $this->queryBuilder
            ->table('trajets_demandes td')
            ->select([
                'td.trajet_demande_id',
                'td.statut_id',
                'sc.salarie_prenom AS conducteur_prenom',
                'sp.salarie_prenom AS passager_prenom',
                'tp.trajet_lieu_arrivee',
                'tp.trajet_lieu_depart',
                'tp.trajet_heure_depart'
            ])
            ->from()
            ->joinOn('salaries sp', 'sp', 'salarie_id', 'td', 'salarie_id')
            ->joinOn('trajets_proposes tp', 'tp', 'trajet_id', 'td', 'trajet_id')
            ->joinOn('salaries sc', 'sc', 'salarie_id', 'tp', 'salarie_id');
        if ($userRole === 'passenger') {
            $data->where('salarie_id','=',$userId,'sp');
        }
        else {
            $data->where('salarie_id','=',$userId,'sc');
        } 
        $data
            ->where('statut_id','=','3','td')
            ->query();
        var_dump($data);
        return $data;
    }

}