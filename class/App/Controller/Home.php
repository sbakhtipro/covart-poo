<?php

namespace App\Controller;

class Home extends Controller {

    public function home() {
        // $addresses = new \App\Model\Agencies();
        // $addresses->getAllAddresses();
        $plannedCommutes = new \App\Model\PlannedCommute();
        $plannedCommutes->getInformations($_SESSION['role'],$_SESSION['id']);
        $this->render("user/driver/index");
        // $this->render();   
    }

    // public function plannedCommute() {
        
    // }

}