<?php

// IMPORTANT : MESSAGES ERREUR, GESTION ERREURS
// NB PASSAGERS A LIMITER AVANT ENTREE DANS BDD -> A TESTER! (front: laisser possibilité de prendre 4 passagers dans select option)
// VERIFIER SI FEEDBACK PAS OK -> voir avec execute qui retourne true false
// REVOIR LES VERIFICATIONS AVANT ENTREE DANS BDD
// docstrings!

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
        // CONSTRUCTEUR REDEFINI = APPEL AU CONSTRUCTEUR PARENT !
        parent::__construct();
        $this->tableDaysAller = $_SESSION['form']['table-days-aller'] ?? [];
        $this->tableDaysRetour = $_SESSION['form']['table-days-retour'] ?? [];
        $this->formFields = [
            $this->chooseAddress => [
                'type_trajet_id' => [
                    'type' => 'int'
                ],
                'trajet_lieu_depart' => [
                    'min' => 3,
                    'max' => 50,
                    'type' => 'string'
                ],
                'trajet_lieu_arrivee' => [
                    'min' => 3,
                    'max' => 50,
                    'type' => 'string'
                ],
                'trajet_lieu_depart_lat' => [
                    'type' => 'float'
                ],
                'trajet_lieu_depart_lon' => [
                    'type' => 'float'
                ],
                'trajet_lieu_arrivee_lat' => [
                    'type' => 'float'
                ],
                'trajet_lieu_arrivee_lon' => [
                    'type' => 'float'
                ],
            ],
            $this->chooseVehicle => [
                'trajet_nb_places' => [
                    'type' => 'int'
                ],
                'vehicule_id' => [
                    'type' => 'int'
                ]
            ],
            $this->chooseTimes => [
                'trajet_date_heure_depart' => [
                    'type' => 'string'
                ],
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
        $exportAddresses = new \Core\Service\ExportJSON();
        $exportAddresses->exportData($addresses);
    }

    public function chooseAddress($e=[]): void {
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
        $this->formValidator->clearStepInSession($this->chooseTimes);
        var_dump($_SESSION['form'][$this->chooseAddress]);
        var_dump($this->tableDaysAller);
        var_dump($this->tableDaysRetour);
        $chooseAddressOK = $this->formValidator->checkStep($this->chooseAddress);
        $chooseVehicleOK = $this->formValidator->checkStep($this->chooseVehicle);
        if (!$chooseAddressOK) {
            $this->redirect('index.php?controller=propose-commute&method=choose-address');
        }
        if (!$chooseVehicleOK) {
            $this->redirect('index.php?controller=propose-commute&method=choose-vehicle');
        }
        if ($_SESSION['form'][$this->chooseAddress]['type_trajet_id'] == '1') {
            $tableDays = $this->tableDaysAller;
        }
        else if ($_SESSION['form'][$this->chooseAddress]['type_trajet_id'] == '2') {
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
            $this->redirect('index.php?controller=propose-commute&method=choose-times');
        }
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
        $this->render('user/driver/propose-commute/summary', compact('data'));
    }

    public function checkCommutesData(): void {
        $chooseAddressOK = $this->formValidator->checkStep($this->chooseAddress);
        $chooseVehicleOK = $this->formValidator->checkStep($this->chooseVehicle);
        $chooseTimesOK = $this->formValidator->checkStep($this->chooseTimes);
        if (!$chooseAddressOK) {
            $test = 'test';
            var_dump($test);
            exit;
            $this->redirect('index.php?controller=propose-commute&method=choose-address');
        }
        if (!$chooseVehicleOK) {
            $this->redirect('index.php?controller=propose-commute&method=choose-vehicle');
        }
        if (!$chooseTimesOK) {
            $this->redirect('index.php?controller=propose-commute&method=choose-times');
        }
        $this->checkTokenCSRF();
        $this->checkUserRole();
        if ($_SESSION['form'][$this->chooseAddress]['type_trajet_id'] == 1 || $_SESSION['form'][$this->chooseAddress]['type_trajet_id'] == 2) {
            $type = $_SESSION['form'][$this->chooseAddress]['type_trajet_id'];
        }
        else {
            $test = 'test';
            var_dump($test);
            exit;
            $this->redirect('index.php?controller=propose-commute&method=choose-address');
        }
        $getModelProposedCommutes = new \App\Model\ProposeCommute();
        $proposedCommutes = $getModelProposedCommutes->getAllUserProposedCommutes($type);
        foreach ($proposedCommutes as $proposedCommute) {
            $dateFromObject = $proposedCommute->getDepartureTime();
            $date = $dateFromObject->format('Y-m-d');
            foreach ($_SESSION['form'][$this->chooseTimes]['trajet_date_heure_depart'] as $key => $value) {
                $keyArray = explode('_',$key);
                if ($date == $keyArray[1]) {
                    $test = 'test';
                    var_dump($test);
                    exit;
                    $this->redirect('index.php?controller=propose-commute&method=choose-address');
                }
            }
        }
        $this->redirect('index.php?controller=propose-commute&method=send-commutes-data');
    }

    private function checkTokenCSRF(): void {
        if ($_SESSION['form'][$this->chooseAddress]['token-csrf'] != $_SESSION['token_csrf'] || $_SESSION['form'][$this->chooseVehicle]['token-csrf'] != $_SESSION['token_csrf'] || $_SESSION['form'][$this->chooseTimes]['token-csrf'] != $_SESSION['token_csrf']) {
            // rediriger vers page d'erreur
            $this->redirect('index.php?controller=driver-home&method=display-home');
        }
    }

    private function checkUserRole(): void {
        $role = new \App\Auth\UserAuth();
        $role->isDriver();
    }

    public function sendCommutesData(): void {
        foreach ($_SESSION['form'][$this->chooseTimes]['trajet_date_heure_depart'] as $key => $value) {
            $date = explode('_',$key);
            $postCommutes = new \App\Model\ProposeCommute();
            $postCommutes->insertCommutesData($_SESSION['form'], $date[1] . ' ' . $value);
        }
        $this->formValidator->clearStepInSession($this->chooseAddress);
        $this->formValidator->clearStepInSession($this->chooseVehicle);
        $this->formValidator->clearStepInSession($this->chooseTimes);
        $this->redirect('index.php?controller=propose-commute&method=feedback-ok');
    }

    public function feedbackOk() {
        $this->render('user/driver/propose-commute/feedback-ok');
    }

}