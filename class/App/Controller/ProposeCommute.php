<?php

namespace App\Controller;

class ProposeCommute extends Controller {

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
        // var_dump($_POST['commute-type']);
        // var_dump($_POST['input-address']);
        // var_dump($_POST['list-address']);
        // var_dump($_POST['coordonnees-list']);
        // var_dump($_POST['coordonnees-input']);
        // exit;
        if (!empty($_POST['commute-type']) && !empty($_POST['input-address']) && !empty($_POST['list-address']) && !empty($_POST['coordonnees-list']) && !empty($_POST['coordonnees-input'])) {
            $this->redirect('index.php?controller=propose-commute&method=choose-times');
        }
        $_SESSION['form-first-step']['commute-type'] = $_POST['commute-type'];
        if ($_SESSION['form-first-step']['commute-type'] === 1) {
            $_SESSION['form-first-step']['departure-address'] = $_POST['input-address'];
            $_SESSION['form-first-step']['arrival-address'] = $_POST['list-address'];
            $_SESSION['form-first-step']['arrival-coordinates'] = $_POST['coordonnees-list'];
            $_SESSION['form-first-step']['departure-coordinates'] = $_POST['coordonnees-input'];
        }
        else if ($_SESSION['form-first-step']['commute-type'] === 2) {
            $_SESSION['form-first-step']['arrival-address'] = $_POST['input-address'];
            $_SESSION['form-first-step']['departure-address'] = $_POST['list-address'];
            $_SESSION['form-first-step']['departure-coordinates'] = $_POST['coordonnees-list'];
            $_SESSION['form-first-step']['arrival-coordinates'] = $_POST['coordonnees-input'];
        }
        else {
            $this->redirect('index.php?controller=propose-commute&method=choose-address');
        }
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
        $tableDays = $this->createTableDays();
        var_dump($tableDays);
        $this->render('user/driver/propose-commute/choose-times', compact('tableDays'));
    }

    public function saveStep2Data() {
        // var_dump($_POST['dates']);
        // exit;
        foreach ($_POST['dates'] as $day) {
            if (empty($_POST['time-'.$day])) {
                $this->redirect('index.php?controller=propose-commute&method=choose-times');
            }
        }
        foreach ($_POST['dates'] as $day) {
            var_dump($day);
            exit;
            $_SESSION['commute-days']['day-'.$day] = [
                'day' => $day,
                'time' => $_POST['time-'.$day]
            ];
        }
        var_dump($_SESSION['commute-days']);
        exit;
    }

}