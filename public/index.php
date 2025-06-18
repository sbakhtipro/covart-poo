<?php

use App\Database\QueryBuilder;

require_once "../class/App/App.php";

App\App::init();

// $query = new \App\Database\QueryBuilder();

// $query
//     ->table('salaries')
//     ->select([
//         'salarie_prenom',
//         'salarie_nom',
//     ])
//     // ->select()
//     // ->insertInto([
//     //     'salarie_prenom' => 'Sarah',
//     //     'salarie_nom' => 'H',
//     // ])
//     // ->delete()
//     ->from()
//     ->joinOn([
//         [
//             'table' => 'postes',
//             'leftColumnTable' => 'postes',
//             'leftColumn' => 'poste_id',
//             'rightColumnTable' => 'salaries',
//             'rightColumn' => 'poste_id',
//         ],
//     ])
//     ->where([
//         [   
//             'table' => 'salaries',
//             'condition' => 'poste_id',
//             'operator' => '=',
//             'value' => '2',
//         ],
//     ])
//     // ->joinOn([
//     //     [
//     //         'table' => 'services',
//     //         'leftColumnTable' => 'services',
//     //         'leftColumn' => 'service_id',
//     //         'rightColumnTable' => 'salaries',
//     //         'rightColumn' => 'salarie_id',
//     //     ],
//     // ])
//     ->query();

// // App\Router\Router::run();