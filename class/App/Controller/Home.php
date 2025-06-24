<?php

namespace App\Controller;

class Home extends Controller {

    public function displayHome($userRole,$userId) {
        // $addresses = new \App\Model\Agencies();
        // $addresses->getAllAddresses();
        $plannedCommutes = new \App\Model\PlannedCommute();
        $plannedCommutes->getInformations($userRole,$userId);
        $this->render("user/" . $userRole . "/index");
        // $this->render();   
    }

    public function switchRole($role) {
        try {
           if ($role === 'passenger') {
                $roleId = 1;
            }
            else if ($role === 'driver') {
                $roleId = 2;
            }
            else {
                throw new \InvalidArgumentException("Rôle invalide : $role");
            }
        }
        catch (\InvalidArgumentException $e) {
            $this->redirect('index.php');
        }
        $_SESSION['role'] = $role;
        $user = new \App\Model\User();
        $user->updateLastRole($roleId);
    }

}