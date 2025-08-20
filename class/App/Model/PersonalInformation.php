<?php

namespace App\Model;

class PersonalInformation extends Model {

        public function getPersonalInformations($userId) {
        $row = $this->queryBuilder
            ->table('salaries')
            ->select(['salaries.salarie_nom','salaries.salarie_prenom','salaries.salarie_date_naissance','utilisateurs.utilisateur_numero_telephone','utilisateurs.utilisateur_email','utilisateurs.utilisateur_adresse'])
            ->from()
            ->joinOn('utilisateurs','utilisateurs','salarie_id','salaries','salarie_id')
            ->where('salarie_id','=',$userId,'salaries')
            ->query(false);
        $personalInformations = [];
        $employee = new \App\Entity\Employees();
        $employee->setFirstName($row['salarie_prenom']);
        $employee->setName($row['salarie_nom']);
        $employee->setBirthDate($row['salarie_date_naissance']);
        $user = new \App\Entity\Users();
        $user->setPhoneNumber($row['utilisateur_numero_telephone']);
        $user->setMail($row['utilisateur_email']);
        $user->setAddress($row['utilisateur_adresse']);
        $personalInformations['employee'] = $employee;
        $personalInformations['user'] = $user;
        return $personalInformations;
    }

}