<?php

namespace App\Controller;

class ProposedCommute extends Controller {

    public function formFirstStep() {
        $addresses = new \App\Model\Agencies();
        $addresses->getAllAddresses();
        $this->render("listing", compact("addresses"));
    }

    public function saveInputsValues() {
        if (isset($_POST['commute-type']) && isset($_POST['input-address']) && isset($_POST['list-address']) && isset($_POST['coordonnees-list']) && isset($_POST['coordonnees-input'])) {
            $_SESSION['form-first-step']['commute-type'] = $_POST['commute-type'];
            $_SESSION['form-first-step']['input-address'] = $_POST['input-address'];
            $_SESSION['form-first-step']['list-address'] = $_POST['list-address'];
            $_SESSION['form-first-step']['coordonnees-list'] = $_POST['coordonnees-list'];
            $_SESSION['form-first-step']['coordonnees-input'] = $_POST['coordonnees-input'];
            return true;
        }
        return false;
    }

    public function formSecondStep() {
        if ($this->saveInputsValues()) {
            $this->redirect('');
        }
    }

    

}