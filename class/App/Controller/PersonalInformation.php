<?php

// ajouter variable is_logged

namespace App\Controller;

class PersonalInformation extends Controller {

    public function getPersonalInformation() {
        $getInformations = new \App\Model\PersonalInformation();
        $informations = $getInformations->getPersonalInformations($_SESSION['id']);
        $token = $_SESSION['token_csrf'];
        $this->render('user/personal-information', compact('informations','token'));
    }

    public function updatePersonalInformation() {
        
    }
}




    