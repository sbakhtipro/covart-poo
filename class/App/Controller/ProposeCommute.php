<?php

namespace App\Controller;

class ProposeCommute extends Controller {

    public array $tableDaysAller;
    public array $tableDaysRetour;

    public function __construct() {
        $this->tableDaysAller = $_SESSION['table-days-aller'] ?? [];
        $this->tableDaysRetour = $_SESSION['table-days-retour'] ?? [];
    }

    private function checkStep1() {
        if (empty($_SESSION['form-first-step']['arrival-address']) || empty($_SESSION['form-first-step']['departure-address']) || empty($_SESSION['form-first-step']['arrival-coordinates']['lat']) || empty($_SESSION['form-first-step']['arrival-coordinates']['lon']) || empty($_SESSION['form-first-step']['departure-coordinates']['lat']) || empty($_SESSION['form-first-step']['commute-type'])) {
            $this->redirect('index.php?controller=propose-commute&method=choose-address');
        }
    }

    private function checkStep2() {
        if (empty($_SESSION['form-second-step']['passengers-number']) || empty($_SESSION['form-second-step']['vehicle'])) {
            $this->redirect('index.php?controller=propose-commute&method=choose-vehicle');
        }
    }

    public function startProposeCommute() {
        $getModelProposedCommutes = new \App\Model\ProposeCommute();
        $proposedCommutesAller = $getModelProposedCommutes->getAllUserProposedCommutes(1);
        $proposedCommutesRetour = $getModelProposedCommutes->getAllUserProposedCommutes(2); 
        $tableDaysAller = $this->arrayProposedCommutes($proposedCommutesAller);
        $tableDaysRetour = $this->arrayProposedCommutes($proposedCommutesRetour);
        $_SESSION['table-days-aller'] = $tableDaysAller;
        $_SESSION['table-days-retour'] = $tableDaysRetour;
        $this->redirect('index.php?controller=propose-commute&method=choose-address');
    }

    private function arrayProposedCommutes($array) {
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

    public function fetchAddresses() {
        $getAddresses = new \App\Model\Agencies();
        $addresses = $getAddresses->getAllAddresses();
        $exportAddresses = new \App\Service\ExportJSON();
        $exportAddresses->exportData($addresses);
    }

    public function chooseAddress() {
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
        $this->render('user/driver/propose-commute/choose-address', compact('types','availableTypes'));
    }

    public function saveStep1Data() {
        if (empty($_POST['commute-type']) || empty($_POST['input-address']) || empty($_POST['list-address']) || empty($_POST['coordonnees-list']) || empty($_POST['coordonnees-input'])) {
            $this->redirect('index.php?controller=propose-commute&method=choose-address');
        }
        $_SESSION['form-first-step']['commute-type'] = $_POST['commute-type'];
        if ($_SESSION['form-first-step']['commute-type'] == 1) {
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
        else if ($_SESSION['form-first-step']['commute-type'] == 2) {
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
    
    public function chooseVehicle() {
        $this->checkStep1();
        $getVehicles = new \App\Model\Vehicle();
        $vehicles = $getVehicles->getUserVehicles();
        $this->render('user/driver/propose-commute/choose-vehicle', compact('vehicles'));
    }

    public function saveStep2Data() {
        if (empty($_POST['passengers_number']) || empty($_POST['vehicle'])) {
            $this->redirect('index.php?controller=propose-commute&method=choose-vehicle');
        }
        $_SESSION['form-second-step']['passengers-number'] = $_POST['passengers_number'];
        $_SESSION['form-second-step']['vehicle'] = $_POST['vehicle'];
        $this->redirect('index.php?controller=propose-commute&method=choose-times');
    }

    public function createTableDays() {
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
            $date->modify('+' . $i+1 . ' days');
            $dateStr = $date->format('Y-m-d');
            $dayOfTheWeek = $formatter->format($date);
            $day = [
                'date' => $dateStr,
                'day' => $dayOfTheWeek,
            ];
            array_push($tableDays,$day);
        }
        return $tableDays;
    }

    public function chooseTimes() {
        $this->checkStep1();
        $this->checkStep2();
        if ($_SESSION['form-first-step']['commute-type'] === '1') {
            $tableDays = $this->tableDaysAller;
        }
        else if ($_SESSION['form-first-step']['commute-type'] === '2') {
            $tableDays = $this->tableDaysRetour;
        }
        
        $this->render('user/driver/propose-commute/choose-times', compact('tableDays'));
    }

    public function saveStep3Data() {
        foreach ($_POST['dates'] as $day) {
            if (empty($_POST['time-'.$day])) {
                $this->redirect('index.php?controller=propose-commute&method=choose-times');
            }
        }
        foreach ($_POST['dates'] as $day) {
            $_SESSION['form-third-step'][$day] = $_POST['time-'.$day];
        }
        $this->redirect('index.php?controller=propose-commute&method=summary');
    }

    public function summary() {
        $this->checkStep1();
        $this->checkStep2();
        $data = [
            'commute-type' => $_SESSION['form-first-step']['commute-type'],
            'departure-address' => $_SESSION['form-first-step']['departure-address'],
            'arrival-address' => $_SESSION['form-first-step']['arrival-address'],
            'arrival-coordinates' => [
                'lat' => $_SESSION['form-first-step']['arrival-coordinates']['lat'],
                'lon' => $_SESSION['form-first-step']['arrival-coordinates']['lon'],
            ],
            'departure-coordinates' => [
                'lat' => $_SESSION['form-first-step']['departure-coordinates']['lat'],
                'lon' => $_SESSION['form-first-step']['departure-coordinates']['lon'],
            ],
            'passengers-number' => $_SESSION['form-second-step']['passengers-number'],
            'vehicle' => $_SESSION['form-second-step']['vehicle'],
        ];
        foreach ($_SESSION['form-third-step'] as $date=>$time) {
            $dayAndDate = explode("_",$date);
            $data['commute-dates'][$dayAndDate[1]] = [
                'day' => $dayAndDate[0],
                'time' => $time
            ];
        }
        var_dump($_SESSION['form-third-step']);
        exit;
        $this->render('user/driver/propose-commute/summary', compact('data'));
    }

    public function checkCommutesData() {
        $this->checkStep1();
        $this->checkStep2();
        if ($_SESSION[['form-first-step']['commute-type'] === 'aller']) {
            $type = 1;
        }
        else if ($_SESSION[['form-first-step']['commute-type'] === 'retour']) {
            $type = 2;
        }
        else {
            $this->redirect('index.php?controller=propose-commute&method=choose-address');
        }
        $getModelProposedCommutes = new \App\Model\ProposeCommute();
        $proposedCommutes = $getModelProposedCommutes->getAllUserProposedCommutes($type);
        foreach ($proposedCommutes as $proposedCommute) {
            $dateFromObject = $proposedCommute->getDepartureTime();
            $date = $dateFromObject->format('Y-m-d');
            foreach ($_SESSION['form-third-step'] as $key => $value) {
                $dateWithoutDay = implode('_',$key);
                if ($date == $dateWithoutDay[1]) {
                    $this->redirect('index.php?controller=propose-commute&method=choose-address');
                }
            }
        }
        $this->redirect('index.php?controller=propose-commute&method=send-commutes-data');
    }

    public function sendCommutesData() {
        $postCommutes = new \App\Model\ProposeCommute();
        $postCommutes->insertCommutesData();
    }

}