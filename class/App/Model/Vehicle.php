<?php

namespace App\Model;

use App\Entity\Vehicles;

class Vehicle extends Model {

    public function getUserVehicles() {
        $recordset = $this->queryBuilder
            ->table('vehicules')
            ->select(['vehicules.vehicule_id', 'vehicules.vehicule_plaque_immatriculation', 'vehicules.modele_vehicule_id', 'vehicules.salarie_id','modeles_vehicules.modele_vehicule_nom','modeles_vehicules.marque_vehicule_id','marques_vehicules.marque_vehicule_nom'])
            ->from()
            ->joinOn('utilisateurs', 'utilisateurs', 'salarie_id', 'vehicules','salarie_id')
            ->joinOn('modeles_vehicules', 'modeles_vehicules', 'modele_vehicule_id', 'vehicules', 'modele_vehicule_id')
            ->joinOn('marques_vehicules', 'marques_vehicules', 'marque_vehicule_id', 'modeles_vehicules', 'marque_vehicule_id')
            ->where('salarie_id', '=', $_SESSION['id'],'vehicules')
            ->query();
        var_dump($recordset);
        $vehicles = [];
        if (is_array($recordset)) {
            foreach ($recordset as $row) {
                $vehicle = new Vehicles();
                $vehicle->setId($row['vehicule_id']);
                $vehicle->setRegistrationPlate($row['vehicule_plaque_immatriculation']);
                $vehicle->setVehicleModelId($row['modele_vehicule_id']);
                $vehicle->setEmployeeId($row['salarie_id']);
                array_push($vehicles, $vehicle);
            }  
        }
        return $vehicles;
    }
}