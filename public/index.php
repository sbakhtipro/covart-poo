<?php

use App\Database\QueryBuilder;

require_once "../class/App/App.php";

App\App::init();

// $query = new \App\Database\QueryBuilder();

// $query
//     ->table('salaries')
//     ->select(['salarie_prenom','salarie_nom'])
//     ->from()
//     ->joinOn('services', 'services', 'service_id', 'salaries', 'salarie_id')
//     ->joinOn('services', 'services', 'service_id', 'salaries', 'salarie_id')
//     ->where('poste_id1','=','2',)
//     ->where('poste_id','=','2','salaries')
//     ->query();

// App\Router\Router::run();

$test = new \App\Model\Agencies();

$test->getAllAddresses();