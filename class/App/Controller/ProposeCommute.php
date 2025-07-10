<?php

// IMPORTANT : FILTER INPUT, MESSAGES ERREUR, GESTION ERREURS, FORM VALIDATOR, REFACTO, DRY SAVE STEP 1

namespace App\Controller;

use DateTime;

class ProposeCommute extends Controller {

    public array $tableDaysAller = [];
    public array $tableDaysRetour = [];
    public array $data = [];

    public function __construct() {
        $this->tableDaysAller = $_SESSION['table-days-aller'] ?? [];
        $this->tableDaysRetour = $_SESSION['table-days-retour'] ?? [];
        $this->data = [
            'form-step-1' => [
                'commute-type' => [
                    'id' => $_SESSION['form-first-step']['commute-type']['id'] ?? '',
                    'name' => $_SESSION['form-first-step']['commute-type']['name'] ?? ''
                ] ?? [],
                'departure-address' => $_SESSION['form-first-step']['departure-address'] ?? '',
                'arrival-address' => $_SESSION['form-first-step']['arrival-address'] ?? '',
                'arrival-coordinates' => [
                    'lat' => $_SESSION['form-first-step']['arrival-coordinates']['lat'] ?? '',
                    'lon' => $_SESSION['form-first-step']['arrival-coordinates']['lon'] ?? '',
                ] ?? [],
                'departure-coordinates' => [
                    'lat' => $_SESSION['form-first-step']['departure-coordinates']['lat'] ?? '',
                    'lon' => $_SESSION['form-first-step']['departure-coordinates']['lon'] ?? '',
                ] ?? [],
                'token-csrf' => $_SESSION['form-first-step']['token-csrf'] ?? ''
            ] ?? [],
            'form-step-2' => [
                'passengers-number' => $_SESSION['form-second-step']['passengers-number'] ?? '',
                'vehicle' => $_SESSION['form-second-step']['vehicle'] ?? '',
                'token-csrf' => $_SESSION['form-second-step']['token-csrf'] ?? ''
            ] ?? [],
            'form-step-3' => [
                'token-csrf' => $_SESSION['form-third-step']['token-csrf'] ?? ''
            ]                    
        ];
        if (isset($_SESSION['form-third-step'])) {
            // $this->data['form-step-3']['token-csrf'] = $_SESSION['form-third-step']['token-csrf'];
            foreach ($_SESSION['form-third-step']['commute-dates'] as $date=>$time) {
                $dayAndDate = explode("_",$date);
                $dateObject = new DateTime($dayAndDate[1]);
                $date = $dateObject->format('d.m');
                $this->data['form-step-3']['commute-dates'][$dayAndDate[1]] = [
                    'day' => $dayAndDate[0],
                    'date' => $date,
                    'time' => $time
                ];
            }
        }
    }

    private function checkStep1(): void {
        if (empty($_SESSION['form-first-step']['arrival-address']) || empty($_SESSION['form-first-step']['departure-address']) || empty($_SESSION['form-first-step']['arrival-coordinates']['lat']) || empty($_SESSION['form-first-step']['arrival-coordinates']['lon']) || empty($_SESSION['form-first-step']['departure-coordinates']['lat']) || empty($_SESSION['form-first-step']['commute-type']) || empty($_SESSION['form-first-step']['token-csrf'])) {
            $this->redirect('index.php?controller=propose-commute&method=choose-address');
        }
    }

    private function checkStep2(): void {
        if (empty($_SESSION['form-second-step']['passengers-number']) || empty($_SESSION['form-second-step']['vehicle']) || empty($_SESSION['form-second-step']['token-csrf'])) {
            $this->redirect('index.php?controller=propose-commute&method=choose-vehicle');
        }
    }

    private function checkStep3(): void {
        if (empty($_SESSION['form-third-step']['commute-dates']) || empty($_SESSION['form-third-step']['token-csrf'])) {
            $this->redirect('index.php?controller=propose-commute&method=choose-timesS');
        }
    }

    private function clearStep1(): void {
        if (isset($_SESSION['form-first-step'])) {
            unset($_SESSION['form-first-step']);
        }
    }

    private function clearStep2(): void {
        if (isset($_SESSION['form-second-step'])) {
            unset($_SESSION['form-second-step']);
        }
    }

    private function clearStep3(): void {
        if (isset($_SESSION['form-third-step'])) {
            unset($_SESSION['form-third-step']);
        }
    }

    private function startProposeCommute(): void {
        $getModelProposedCommutes = new \App\Model\ProposeCommute();
        $proposedCommutesAller = $getModelProposedCommutes->getAllUserProposedCommutes(1);
        $proposedCommutesRetour = $getModelProposedCommutes->getAllUserProposedCommutes(2); 
        $tableDaysAller = $this->arrayProposedCommutes($proposedCommutesAller);
        $tableDaysRetour = $this->arrayProposedCommutes($proposedCommutesRetour);
        $_SESSION['table-days-aller'] = $tableDaysAller;
        $_SESSION['table-days-retour'] = $tableDaysRetour;
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

    public function chooseAddress(): void {
        var_dump($_SESSION);
        exit;
        $this->startProposeCommute();
        $this->clearStep1();
        $data = [];
        if (isset($_SESSION['form-first-step'])) {
            $data = $this->data['form-step-1'];
        }
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
        $this->render('user/driver/propose-commute/choose-address', compact('types','availableTypes','data','token'));
    }

    public function saveStep1Data(): void {
        if (empty($_POST['commute-type']) || empty($_POST['input-address']) || empty($_POST['list-address']) || empty($_POST['coordonnees-list']) || empty($_POST['coordonnees-input']) || empty($_POST['token-csrf'])) {
            $this->redirect('index.php?controller=propose-commute&method=choose-address');
        }
        $_SESSION['form-first-step']['token-csrf'] = $_POST['token-csrf'];
        $_SESSION['form-first-step']['commute-type']['id'] = $_POST['commute-type'];
        if ($_SESSION['form-first-step']['commute-type']['id'] == 1) {
            $_SESSION['form-first-step']['commute-type']['name'] = 'aller';
            $_SESSION['form-first-step']['departure-address'] = $_POST['input-address'];
            $_SESSION['form-first-step']['arrival-address'] = $_POST['list-address'];
            $arrayDepartureCoordinates = explode(', ', $_POST['coordonnees-input']);
            $arrayArrivalCoordinates = explode(', ', $_POST['coordonnees-list']);
            $_SESSION['form-first-step']['arrival-coordinates']['lat'] = $arrayArrivalCoordinates[0];
            $_SESSION['form-first-step']['arrival-coordinates']['lon'] = $arrayArrivalCoordinates[1];
            $_SESSION['form-first-step']['departure-coordinates']['lat'] = $arrayDepartureCoordinates[0];
            $_SESSION['form-first-step']['departure-coordinates']['lon'] = $arrayDepartureCoordinates[1];
            $this->redirect('index.php?controller=propose-commute&method=choose-vehicle');
        }
        else if ($_SESSION['form-first-step']['commute-type']['id'] == 2) {
            $_SESSION['form-first-step']['commute-type']['name'] = 'retour';
            $_SESSION['form-first-step']['arrival-address'] = $_POST['input-address'];
            $_SESSION['form-first-step']['departure-address'] = $_POST['list-address'];
            $arrayDepartureCoordinates = explode(',',$_POST['coordonnees-list']);
            $arrayArrivalCoordinates = explode(',',$_POST['coordonnees-input']);
            $_SESSION['form-first-step']['arrival-coordinates']['lat'] = $arrayArrivalCoordinates[0];
            $_SESSION['form-first-step']['arrival-coordinates']['lon'] = $arrayArrivalCoordinates[1];
            $_SESSION['form-first-step']['departure-coordinates']['lat'] = $arrayDepartureCoordinates[0];
            $_SESSION['form-first-step']['departure-coordinates']['lon'] = $arrayDepartureCoordinates[1];
            $this->redirect('index.php?controller=propose-commute&method=choose-vehicle');
        }
        else {
            $this->redirect('index.php?controller=propose-commute&method=choose-address');
        }
    }
    
    public function chooseVehicle(): void {
        $this->clearStep2();
        $this->checkStep1();
        $getVehicles = new \App\Model\Vehicle();
        $vehicles = $getVehicles->getUserVehicles();
        $token = $_SESSION['token_csrf'];
        $this->render('user/driver/propose-commute/choose-vehicle', compact('vehicles','token'));
    }

    public function saveStep2Data(): void {
        if (empty($_POST['passengers_number']) || empty($_POST['vehicle']) || empty($_POST['token-csrf'])) {
            $this->redirect('index.php?controller=propose-commute&method=choose-vehicle');
        }
        $_SESSION['form-second-step']['token-csrf'] = $_POST['token-csrf'];
        $_SESSION['form-second-step']['passengers-number'] = $_POST['passengers_number'];
        $_SESSION['form-second-step']['vehicle'] = $_POST['vehicle'];
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
        $this->clearStep3();
        // var_dump($_SESSION);
        $this->checkStep1();
        $this->checkStep2();
        if ($_SESSION['form-first-step']['commute-type']['id'] === '1') {
            $tableDays = $this->tableDaysAller;
        }
        else if ($_SESSION['form-first-step']['commute-type']['id'] === '2') {
            $tableDays = $this->tableDaysRetour;
        }
        $token = $_SESSION['token_csrf'];
        $this->render('user/driver/propose-commute/choose-times', compact('tableDays','token'));
    }

    public function saveStep3Data() {
        if (empty($_POST['token-csrf'])) {
            $this->redirect('index.php?controller=propose-commute&method=choose-times');
        }
        $_SESSION['form-third-step']['token-csrf'] = $_POST['token-csrf'];
        foreach ($_POST['dates'] as $day) {
            if (empty($_POST['time-'.$day])) {
                $this->redirect('index.php?controller=propose-commute&method=choose-times');
            }
        }
        foreach ($_POST['dates'] as $day) {
            $_SESSION['form-third-step']['commute-dates'][$day] = $_POST['time-'.$day];
        }
        $this->redirect('index.php?controller=propose-commute&method=summary');
    }

    public function summary(): void {
        $this->checkStep1();
        $this->checkStep2();
        $this->checkStep3();
        $data = $this->data;
        // var_dump($this->data);
        // exit;
        $this->render('user/driver/propose-commute/summary', compact('data'));
    }

    public function checkCommutesData(): void {
        $this->checkStep1();
        $this->checkStep2();
        $this->checkStep3();
        $this->checkTokenCSRF();
        $this->checkUserRole();
        if ($_SESSION['form-first-step']['commute-type']['id'] == 1 || $_SESSION['form-first-step']['commute-type']['id'] == 2) {
            $type = $_SESSION['form-first-step']['commute-type']['id'];
        }
        else {
            // echo 'test';
            // exit;
            $this->redirect('index.php?controller=propose-commute&method=choose-address');
        }
        $getModelProposedCommutes = new \App\Model\ProposeCommute();
        $proposedCommutes = $getModelProposedCommutes->getAllUserProposedCommutes($type);
        foreach ($proposedCommutes as $proposedCommute) {
            $dateFromObject = $proposedCommute->getDepartureTime();
            $date = $dateFromObject->format('Y-m-d');
            foreach ($_SESSION['form-third-step']['commute-dates'] as $key => $value) {
                $keyArray = explode('_',$key);
                if ($date == $keyArray[1]) {
                    $this->redirect('index.php?controller=propose-commute&method=choose-address');
                }
            }
        }
        $this->redirect('index.php?controller=propose-commute&method=send-commutes-data');
    }

    private function checkTokenCSRF(): void {
        if ($this->data['form-step-1']['token-csrf'] != $_SESSION['token_csrf'] || $this->data['form-step-2']['token-csrf'] != $_SESSION['token_csrf'] || $this->data['form-step-3']['token-csrf'] != $_SESSION['token_csrf']) {
            $this->redirect('index.php?controller=user&method=driver-home');
        }
    }

    private function checkUserRole(): void {
        $role = new \App\Auth\UserAuth();
        $role->isDriver();
    }

    public function sendCommutesData(): void {
        if (empty($this->data['form-step-3']['commute-dates'])) {
            $this->redirect('index.php?controller=propose-commute&method=choose-times');
        }
        foreach ($this->data['form-step-3']['commute-dates'] as $date => $value) {
            // var_dump($date . ' ' . $value['time']);
            // exit;
            $postCommutes = new \App\Model\ProposeCommute();
            $postCommutes->insertCommutesData($this->data,$date . ' ' . $value['time']);
        }
        $this->clearStep1();
        $this->clearStep2();
        $this->clearStep3();
        $this->redirect('index.php?controller=propose-commute&method=feedback-ok');
    }

    public function feedbackOk() {
        $this->render('user/driver/propose-commute/feedback-ok');
    }

}