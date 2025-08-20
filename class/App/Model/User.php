<?php

namespace App\Model;

class User extends Model {

    public $userCredentials = null;

    public function getUserByCredentials($userEmail) {
        $data = $this->queryBuilder
            ->table('utilisateurs')
            ->select(['utilisateurs.utilisateur_mdp', 'utilisateurs.utilisateur_mdp_perm', 'utilisateurs.utilisateur_permis_verifie', 'utilisateurs.role_id', 'salaries.salarie_id', 'roles.role_nom'])
            ->from()
            ->joinOn('salaries', 'salaries', 'salarie_id', 'utilisateurs', 'salarie_id')
            ->joinOn('roles', 'roles', 'role_id', 'utilisateurs', 'role_id')
            ->where('salarie_email','=',$userEmail,'salaries')
            ->query();
        $this->userCredentials = $data[0];
        var_dump($this->queryBuilder->sql);
        return $this->userCredentials;
    }

    public function updateLastRole($roleId) {
        $lastRole = $this->queryBuilder
            ->table('utilisateurs')
            ->update(['role_id' => $roleId])
            ->query();
        return;
    }

}