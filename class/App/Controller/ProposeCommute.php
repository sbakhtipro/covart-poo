<?php

// IMPORTANT : MESSAGES ERREUR, GESTION ERREURS, FORM VALIDATOR, REFACTO
// NB PASSAGERS A LIMITER AVANT ENTREE DANS BDD

namespace App\Controller;

use DateTime;

class ProposeCommute extends Controller {

    public string $chooseAddress = 'propose-commute-step-1';
    public string $chooseVehicle = 'propose-commute-step-2';
    public string $chooseTimes = 'propose-commute-step-3';
    public array $tableDaysAller = [];
    public array $tableDaysRetour = [];
    public array $formFields = [];

    public function __construct() {
        // CONSTRUCTEUR REDEFINI = APPEL AU CONSTRUCTEUR PARENT !!!!!!
        parent::__construct();
        $this->tableDaysAller = $_SESSION['form']['table-days-aller'] ?? [];
        $this->tableDaysRetour = $_SESSION['form']['table-days-retour'] ?? [];
        $this->formFields = [
            $this->chooseAddress => [
                'type_trajet_id',
                'trajet_lieu_depart',
                'trajet_lieu_arrivee',
                'trajet_lieu_depart_lat',
                'trajet_lieu_depart_lon',
                'trajet_lieu_arrivee_lat',
                'trajet_lieu_arrivee_lon'
            ],
            $this->chooseVehicle => [
                'trajet_nb_places',
                'vehicule_id'
            ],
            $this->chooseTimes => [
                'trajet_date_heure_depart'
            ]
        ];
    }

    private function startProposeCommute(): void {
        $getModelProposedCommutes = new \App\Model\ProposeCommute();
        $proposedCommutesAller = $getModelProposedCommutes->getAllUserProposedCommutes(1);
        $proposedCommutesRetour = $getModelProposedCommutes->getAllUserProposedCommutes(2); 
        $tableDaysAller = $this->arrayProposedCommutes($proposedCommutesAller);
        $tableDaysRetour = $this->arrayProposedCommutes($proposedCommutesRetour);
        $_SESSION['form']['table-days-aller'] = $tableDaysAller;
        $_SESSION['form']['table-days-retour'] = $tableDaysRetour;
    }

    private function arrayProposedCommutes(array $array): array {
        $tableDays = $this->createTableDays();
        foreach ($array as $proposedCommute) {
            $dateFromObject = $proposedCommute->getDepartureTime();
            $date = $dateFromObject->format('Y-m-d');
            $time = $dateFromObject->format('H:i');
            foreach ($tableDays as $key => $day) {
                if ($date === $day['date']) {
                    $tableDays[$key]['already-proposed-commute'] = 'Trajet proposé  à ' . $time;
                }
            }
        }
        return $tableDays;
    }

    public function fetchAddresses(): void {
        $getAddresses = new \App\Model\Agencies();
        $addresses = $getAddresses->getAllAddresses();
        $exportAddresses = new \App\Service\ExportJSON();
        $exportAddresses->exportData($addresses);
    }

    public function chooseAddress($e=[]): void {
        // var_dump($_SESSION['form']);
        // exit;
        $this->startProposeCommute();
        $this->formValidator->clearStepInSession($this->chooseAddress);
        $getTypes = new \App\Model\CommuteTypes();
        $types = $getTypes->getCommuteTypes();
        $aller = 0;
        $retour = 0;
        foreach ($this->tableDaysAller as $key => $day) {
            if (isset($this->tableDaysAller[$key]['already-proposed-commute'])) {
                $aller+=1;
            }
        }
        foreach ($this->tableDaysRetour as $key => $day) {
            if (isset($this->tableDaysRetour[$key]['already-proposed-commute'])) {
                $retour+=1;
            }
        }
        $availableTypes = [
            'aller' => '0',
            'retour' => '0'
        ];
        if ($aller<7) {
            $availableTypes['aller'] = '1';
        }
        if ($retour<7) {
            $availableTypes['retour'] = '1';
        }
        $token = $_SESSION['token_csrf'];
        $this->render('user/driver/propose-commute/choose-address', compact('types','availableTypes','token','e'));
    }

    public function saveStep1Data(): void {
        $fieldsPostValid = $this->formValidator->checkFieldsPost($this->formFields[$this->chooseAddress]);
        if (is_array($fieldsPostValid)) {
            $this->chooseAddress($fieldsPostValid);
        }
        if ($_POST['type_trajet_id'] === '1' || $_POST['type_trajet_id'] === '2') {
            $this->formValidator->saveStepData($this->chooseAddress,$this->formFields[$this->chooseAddress],true);
            // var_dump($_SESSION['form']);
            // exit;
            $this->redirect('index.php?controller=propose-commute&method=choose-vehicle');
        }        
        else {
            $this->redirect('index.php?controller=propose-commute&method=choose-address');
        }
    }
    
    public function chooseVehicle(): void {
        $this->formValidator->clearStepInSession($this->chooseVehicle);
        $chooseAddressOK = $this->formValidator->checkStep($this->chooseAddress);
        if (!$chooseAddressOK) {
            $this->redirect('index.php?controller=propose-commute&method=choose-address');
        }
        $getVehicles = new \App\Model\Vehicle();
        $vehicles = $getVehicles->getUserVehicles();
        $token = $_SESSION['token_csrf'];
        $this->render('user/driver/propose-commute/choose-vehicle', compact('vehicles','token'));
    }

    public function saveStep2Data(): void {
        $fieldsPostValid = $this->formValidator->checkFieldsPost($this->formFields[$this->chooseVehicle]);
        if (is_array($fieldsPostValid)) {
            $this->chooseVehicle($fieldsPostValid);
        }
        $this->formValidator->saveStepData($this->chooseVehicle,$this->formFields[$this->chooseVehicle],true);
        // var_dump($_SESSION['form']);
        // exit;
        $this->redirect('index.php?controller=propose-commute&method=choose-times');
    }

    public function createTableDays(): array {
        $formatter = new \IntlDateFormatter(
            'fr_FR', // langue
            \IntlDateFormatter::FULL,
            \IntlDateFormatter::NONE,
            'Europe/Paris',
            \IntlDateFormatter::GREGORIAN,
            'EEEE' // nom jour
        );
        $timezone = new \DateTimeZone('Europe/Paris');
        $today = new \DateTime('now', $timezone);
        $tableDays = [];
        for ($i=0;$i<7;$i++) {
            $date = clone $today;
            $date->modify('+' . ($i+1) . ' days');
            $dateStr = $date->format('Y-m-d');
            $dayOfTheWeek = $formatter->format($date);
            $tomorrow = ($i===0) ? 'yes' : 'no';
            $day = [
                'date' => $dateStr,
                'day' => $dayOfTheWeek,
                'tomorrow' => $tomorrow
            ];
            array_push($tableDays,$day);
        }
        return $tableDays;
    }

    public function chooseTimes(): void {
        // unset($_POST['dates']);
        $this->formValidator->clearStepInSession($this->chooseTimes);
        // var_dump($_SESSION['form']);
        $chooseAddressOK = $this->formValidator->checkStep($this->chooseAddress);
        $chooseVehicleOK = $this->formValidator->checkStep($this->chooseVehicle);
        if (!$chooseAddressOK) {
            $this->redirect('index.php?controller=propose-commute&method=choose-address');
        }
        if (!$chooseVehicleOK) {
            $this->redirect('index.php?controller=propose-commute&method=choose-vehicle');
        }
        if ($_SESSION['form'][$this->chooseAddress]['type_trajet_id'] === '1') {
            $tableDays = $this->tableDaysAller;
        }
        else if ($_SESSION['form'][$this->chooseAddress]['type_trajet_id'] === '2') {
            $tableDays = $this->tableDaysRetour;
        }
        $token = $_SESSION['token_csrf'];
        $this->render('user/driver/propose-commute/choose-times', compact('tableDays','token'));
    }

    public function saveStep3Data() {
        $fieldsPostValid = $this->formValidator->checkFieldsPost($this->formFields[$this->chooseTimes]);
        if (is_array($fieldsPostValid)) {
            $this->chooseTimes($fieldsPostValid);
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST)) {
                foreach ($_POST['trajet_date_heure_depart'] as $day) {
                    if (empty($_POST['time-'.$day])) {
                        $this->redirect('index.php?controller=propose-commute&method=choose-times');
                    }
                }
                foreach ($_POST['trajet_date_heure_depart'] as $day) {
                    $_SESSION['form'][$this->chooseTimes]['trajet_date_heure_depart'][$day] = $_POST['time-'.$day];
                }
            }
            $_SESSION['form'][$this->chooseTimes]['token-csrf'] = $_POST['token-csrf'];
        }
        $this->redirect('index.php?controller=propose-commute&method=summary');
    }

    public function summary(): void {
        // var_dump($_SESSION['form']);
        // exit;
        $chooseAddressOK = $this->formValidator->checkStep($this->chooseAddress);
        $chooseVehicleOK = $this->formValidator->checkStep($this->chooseVehicle);
        $chooseTimesOK = $this->formValidator->checkStep($this->chooseTimes);
        if (!$chooseAddressOK) {
            $this->redirect('index.php?controller=propose-commute&method=choose-address');
        }
        if (!$chooseVehicleOK) {
            $this->redirect('index.php?controller=propose-commute&method=choose-vehicle');
        }
        if (!$chooseTimesOK) {
            // echo 'AAAAAAAAAAA';
            exit;
            $this->redirect('index.php?controller=propose-commute&method=choose-times');
        }
        // var_dump($_SESSION['form']);
        $data = $_SESSION['form'][$this->chooseAddress] + $_SESSION['form'][$this->chooseVehicle];
        if (isset($_SESSION['form'][$this->chooseTimes])) {
            foreach ($_SESSION['form'][$this->chooseTimes]['trajet_date_heure_depart'] as $date=>$time) {
                $dayAndDate = explode("_",$date);
                $dateObject = new DateTime($dayAndDate[1]);
                $date = $dateObject->format('d.m');
                $data['trajet_date_heure_depart'][$dayAndDate[1]] = [
                    'day' => $dayAndDate[0],
                    'date' => $date,
                    'time' => $time
                ];
            }
        }
        // var_dump($data);
        // exit;
        $this->render('user/driver/propose-commute/summary', compact('data'));
    }

    public function checkCommutesData(): void {
        $chooseAddressOK = $this->formValidator->checkStep($this->chooseAddress);
        $chooseVehicleOK = $this->formValidator->checkStep($this->chooseVehicle);
        $chooseTimesOK = $this->formValidator->checkStep($this->chooseTimes);
        if (!$chooseAddressOK) {
            $this->redirect('index.php?controller=propose-commute&method=choose-address');
        }
        if (!$chooseVehicleOK) {
            $this->redirect('index.php?controller=propose-commute&method=choose-vehicle');
        }
        if (!$chooseTimesOK) {
            exit;
            // $this->redirect('index.php?controller=propose-commute&method=choose-times');
        }
        // var_dump($_SESSION['form']);
        // exit;
        $this->checkTokenCSRF();
        $this->checkUserRole();
        // if ($_SESSION['form'][$this->chooseAddress]['type_trajet_id']['id'] == 1 || $_SESSION['form'][$this->chooseAddress]['type_trajet_id']['id'] == 2) {
        //     $type = $_SESSION['form']['form-first-step']['commute-type']['id'];
        // }
        // else {
        //     // echo 'test';
        //     // exit;
        //     $this->redirect('index.php?controller=propose-commute&method=choose-address');
        // }
        $getModelProposedCommutes = new \App\Model\ProposeCommute();
        $proposedCommutes = $getModelProposedCommutes->getAllUserProposedCommutes($type);
        foreach ($proposedCommutes as $proposedCommute) {
            $dateFromObject = $proposedCommute->getDepartureTime();
            $date = $dateFromObject->format('Y-m-d');
            foreach ($_SESSION['form']['form-third-step']['commute-dates'] as $key => $value) {
                $keyArray = explode('_',$key);
                if ($date == $keyArray[1]) {
                    $this->redirect('index.php?controller=propose-commute&method=choose-address');
                }
            }
        }
        $this->redirect('index.php?controller=propose-commute&method=send-commutes-data');
    }

    private function checkTokenCSRF(): void {
        if ($_SESSION['form'][$this->chooseAddress]['token-csrf'] != $_SESSION['token_csrf'] || $_SESSION['form'][$this->chooseVehicle]['token-csrf'] != $_SESSION['token_csrf'] || $_SESSION['form'][$this->chooseTimes]['token-csrf'] != $_SESSION['token_csrf']) {
            $this->redirect('index.php?controller=driver-home&method=display-home');
        }
    }

    private function checkUserRole(): void {
        $role = new \App\Auth\UserAuth();
        $role->isDriver();
    }

    public function sendCommutesData(): void {
        if (empty($this->data['propose-commute-step-3']['commute-dates'])) {
            $this->redirect('index.php?controller=propose-commute&method=choose-times');
        }
        foreach ($this->data['propose-commute-step-3']['commute-dates'] as $date => $value) {
            // var_dump($date . ' ' . $value['time']);
            // exit;
            $postCommutes = new \App\Model\ProposeCommute();
            $postCommutes->insertCommutesData($this->data,$date . ' ' . $value['time']);
        }
        $this->formValidator->clearStepInSession('form-first-step');
        $this->formValidator->clearStepInSession('form-second-step');
        $this->formValidator->clearStepInSession('form-third-step');
        $this->redirect('index.php?controller=propose-commute&method=feedback-ok');
    }

    public function feedbackOk() {
        $this->render('user/driver/propose-commute/feedback-ok');
    }

}