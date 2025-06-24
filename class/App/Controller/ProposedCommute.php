<?php

namespace App\Controller;

class ProposedCommute extends Controller {

    public function fetchAddresses() {
        $getAddresses = new \App\Model\Agencies();
        $addresses = $getAddresses->getAllAddresses();
        $exportAddresses = new \App\Service\ExportJSON();
        $exportAddresses->exportData($addresses);
    }

    public function chooseAddress() {
        $getTypes = new \App\Model\CommuteTypes();
        $types = $getTypes->getCommuteTypes();
        $this->render('user/driver/propose-commute/choose-address', compact('types'));
    }

    public function saveStep1Data() {
        // $this->redirect('index.php?controller=proposed-commute&method=choose-times');
        // // $this->render('user/driver/propose-commute/choose-address');
        // exit;
        var_dump($_POST['commute-type']);
        var_dump($_POST['input-address']);
        var_dump($_POST['list-address']);
        var_dump($_POST['coordonnees-list']);
        var_dump($_POST['coordonnees-input']);
        exit;
        $_SESSION['form-first-step']['commute-type'] = $_POST['commute-type'];
        $_SESSION['form-first-step']['input-address'] = $_POST['input-address'];
        $_SESSION['form-first-step']['list-address'] = $_POST['list-address'];
        $_SESSION['form-first-step']['coordonnees-list'] = $_POST['coordonnees-list'];
        $_SESSION['form-first-step']['coordonnees-input'] = $_POST['coordonnees-input'];
        if (!empty($_POST['commute-type']) && !empty($_POST['input-address']) && !empty($_POST['list-address']) && !empty($_POST['coordonnees-list']) && !empty($_POST['coordonnees-input'])) {
            $this->redirect('index.php?controller=propose-commute&method=choose-times');
        }
        $this->redirect('index.php?controller=propose-commute&method=choose-address');
    }

    // public function 

    public function chooseTimes() {
        $this->render('user/driver/propose-commute/choose-times');
    }

}