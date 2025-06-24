<?php

// // if (!isDriver()) {
// //     redirect('/index.php?page=login');
// // }

// $stmt = $db->prepare('SELECT * FROM type_trajet');
// $stmt->execute();
// $commuteTypes = $stmt->fetchAll();

// if (isset($_POST['commute-type']) && isset($_POST['input-address']) && isset($_POST['list-address']) && isset($_POST['coordonnees-list']) && isset($_POST['coordonnees-input'])) {
//     // if isset... alors le controleur peut appeler la methode qui fait passer a l'etape 2
//     $_SESSION['commute-type'] = $_POST['commute-type'];
//     $_SESSION['input-address'] = $_POST['input-address'];
//     $_SESSION['list-address'] = $_POST['list-address'];
//     $_SESSION['coordonnees-list'] = $_POST['coordonnees-list'];
//     $_SESSION['coordonnees-input'] = $_POST['coordonnees-input'];
// }

// // fonction date("format dans str, Y-m-d ou d/m/Y"); fuseau horaire heure du serveur -> ce qui est fait ici peut se faire SANS objet
// // récupération de value directement au format SQL


// //_____________________________________________________________
// //_____________________________________________________________
// //_____________________________________________________________

// $formatter = new IntlDateFormatter(
//     'fr_FR', // langue française
//     IntlDateFormatter::FULL,
//     IntlDateFormatter::NONE,
//     'Europe/Paris',
//     IntlDateFormatter::GREGORIAN,
//     'EEEE' // nom complet du jour
// );

// $timezone = new DateTimeZone('Europe/Paris');
// $today = new DateTime('now', $timezone);

// $tableDays = [];

// for ($i=0;$i<8;$i++) {
//     $date = clone $today;
//     $date->modify('+' . $i+1 . ' days');
//     $dateStr = $date->format('Y-m-d');
//     $dayOfTheWeek = $formatter->format($date);
//     $day = [
//         'date' => $dateStr,
//         'day' => $dayOfTheWeek,
//     ];
//     array_push($tableDays,$day);
// }

// //_____________________________________________________________
// //_____________________________________________________________
// //_____________________________________________________________

// // foreach ($tableDays as $day) {
// //     $dayOfTheWeek = $day->format('l');
// //     array_push($day,$dayOfTheWeek);
// // }

// if (isset($_SESSION['commute-type']))
// {var_dump($_SESSION['commute-type']);}


// // if (isset($_POST['horaire-test-date']) && isset($_POST['horaire-test-time'])) {
// //     $dateObj = DateTime::createFromFormat('d/m/Y H:i', $_POST['horaire-test-date'] . ' ' . $_POST['horaire-test-time']);
    
// //     if ($dateObj) {
// //         $datetime = $dateObj->format('Y-m-d H:i:s'); // Résultat : "2025-06-03 14:30:00"
// //     }
// //     else {
// //         echo "Format de date invalide.";
// //     }
// // }

namespace App\Model;

class ProposedCommute extends Model {

    

}