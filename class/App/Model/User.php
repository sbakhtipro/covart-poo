<?php

namespace App\Model;

class User extends Model {

    public $userCredentials = null;

    public function getUserByCredentials($userEmail) {
        $data = $this->queryBuilder
            ->table('utilisateurs')
            ->select(['utilisateurs.utilisateur_mdp', 'utilisateurs.utilisateur_permis_verifie', 'salaries.salarie_id', 'roles.role_nom'])
            ->from()
            ->joinOn('salaries', 'salaries', 'salarie_id', 'utilisateurs', 'salarie_id')
            ->joinOn('utilisateurs_roles', 'utilisateurs_roles', 'salarie_id', 'salaries', 'salarie_id')
            ->joinOn('roles', 'roles', 'role_id', 'utilisateurs_roles', 'role_id')
            ->where('salarie_email','=',$userEmail,'salaries')
            ->query();
        $this->userCredentials = $data[0];
        var_dump($this->queryBuilder->sql);
        return $this->userCredentials;
    }

}