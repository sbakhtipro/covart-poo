<?php

namespace App\Controller;

class ProposeCommute extends Controller {

    public array $tableDays;

    public function __construct() {
        $this->tableDays = $_SESSION['table-days'] ?? [];
    }

    public function startProposeCommute() {
        $getModelProposedCommutes = new \App\Model\ProposeCommute();
        $proposedCommutes = $getModelProposedCommutes->getAllUserProposedCommutes(); 
        $tableDays = $this->createTableDays();
        $aller = 0;
        $retour = 0;
        foreach ($proposedCommutes as $proposedCommute) {
            $dateFromObject = $proposedCommute->getDepartureTime();
            $date = $dateFromObject->format('Y-m-d');
            $type = $proposedCommute->getCommuteTypeId();
            foreach ($tableDays as $key => $day) {
                if ($date === $day['date']) {
                    if ($type === 1) {
                        $a
                    }
                    else if ($type === 2) {

                    }
                    unset($tableDays[$key]);
                }
            }
        }
        $_SESSION['table-days'] = $tableDays;
        // var_dump($this->tableDays);
        // exit;
        $this->redirect('index.php?controller=propose-commute&method=choose-address');
    }

        // public function startProposeCommute() {
        //     $getModelProposedCommutes = new \App\Model\ProposeCommute();
        //     $proposedCommutes = $getModelProposedCommutes->getAllUserProposedCommutes(); 
        //     $tableDays = $this->createTableDays();
        //     foreach ($proposedCommutes as $proposedCommute) {
        //         $dateFromObject = $proposedCommute->getDepartureTime();
        //         $date = $dateFromObject->format('Y-m-d');
        //         $time = $dateFromObject->format('H:i');
        //         foreach ($tableDays as $key => $day) {
        //             if ($date === $day['date']) {
        //                 // unset($tableDays[$key]);
        //                 $tableDays[$key]['already-proposed-commute'] = 'Trajet proposé  à ' . $time;
        //             }
        //         }
        //     }
        //     $_SESSION['table-days'] = $tableDays;
        //     // var_dump($this->tableDays);
        //     // exit;
        //     $this->redirect('index.php?controller=propose-commute&method=choose-address');
        // }

    public function fetchAddresses() {
        $getAddresses = new \App\Model\Agencies();
        $addresses = $getAddresses->getAllAddresses();
        $exportAddresses = new \App\Service\ExportJSON();
        $exportAddresses->exportData($addresses);
    }

    public function chooseAddress() {
        // var_dump($this->tableDays);
        // exit;
        $getTypes = new \App\Model\CommuteTypes();
        $types = $getTypes->getCommuteTypes();
        $this->render('user/driver/propose-commute/choose-address', compact('types'));
    }

    public function saveStep1Data() {
        // var_dump($_POST['commute-type']);
        // var_dump($_POST['input-address']);
        // var_dump($_POST['list-address']);
        // var_dump($_POST['coordonnees-list']);
        // var_dump($_POST['coordonnees-input']);
        // exit;
        if (empty($_POST['commute-type']) || empty($_POST['input-address']) || empty($_POST['list-address']) || empty($_POST['coordonnees-list']) || empty($_POST['coordonnees-input'])) {
            $this->redirect('index.php?controller=propose-commute&method=choose-address');
        }
        $_SESSION['form-first-step']['commute-type'] = $_POST['commute-type'];
        if ($_SESSION['form-first-step']['commute-type'] == 1) {
            $_SESSION['form-first-step']['departure-address'] = $_POST['input-address'];
            $_SESSION['form-first-step']['arrival-address'] = $_POST['list-address'];
            $arrayDepartureCoordinates = explode(', ', $_POST['coordonnees-input']);
            $arrayArrivalCoordinates = explode(', ', $_POST['coordonnees-list']);
            // $arrayArrivalCoordinates = explode(', ', $_POST['coordonnees-list']);
            // var_dump($arrayArrivalCoordinates); // ← Ajoutez ceci pour voir le contenu
            // var_dump(count($arrayArrivalCoordinates));
            // exit;
            // $_SESSION['form-first-step']['arrival-coordinates'] = [];
            // $_SESSION['form-first-step']['departure-coordinates'] = [];
            $_SESSION['form-first-step']['arrival-coordinates']['lat'] = $arrayArrivalCoordinates[0];
            $_SESSION['form-first-step']['arrival-coordinates']['lon'] = $arrayArrivalCoordinates[1];
            // var_dump($_SESSION['form-first-step']['arrival-coordinates']['lat']);
            // var_dump($_SESSION['form-first-step']['arrival-coordinates']['lon']);
            // exit;
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
        var_dump($_SESSION['form-first-step']['commute-type']);
        var_dump($_SESSION['form-first-step']['departure-address']);
        var_dump($_SESSION['form-first-step']['arrival-address']);
        var_dump($_SESSION['form-first-step']['arrival-coordinates']);
        var_dump($_SESSION['form-first-step']['departure-coordinates']);
        // $tableDays = $this->createTableDays();
        var_dump($this->tableDays);
        $tableDays = $this->tableDays;
        var_dump($tableDays);
        $this->render('user/driver/propose-commute/choose-times', compact('tableDays'));
    }

    public function saveStep3Data() {
        // var_dump($_POST['dates']);
        // exit;
        // $this->saveStep1Data(); /!\ redirect dans la méthode qui fume tout
        // $_SESSION['form-first-step'] = '';
        var_dump($_SESSION['form-first-step']['commute-type']);
        var_dump($_SESSION['form-first-step']['departure-address']);
        var_dump($_SESSION['form-first-step']['arrival-address']);
        var_dump($_SESSION['form-first-step']['arrival-coordinates']);
        var_dump($_SESSION['form-first-step']['departure-coordinates']);
        var_dump($_SESSION['form-second-step']['passengers-number']);
        var_dump($_SESSION['form-second-step']['vehicle']);
        // exit;
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
        ];
        foreach ($_SESSION['form-third-step'] as $date=>$time) {
            $dayAndDate = explode("_",$date);
            $data['commute-dates'][$dayAndDate[1]] = [
                'day' => $dayAndDate[0],
                'time' => $time
            ];
        }
        var_dump($data);
        exit;
        // sleep(15);
        $this->render('user/driver/propose-commute/summary', compact('data'));
    }

    public function sendCommuteData() {
        $postCommutes = new \App\Model\ProposeCommute();
        $postCommutes->insertCommutesData();
    }

}