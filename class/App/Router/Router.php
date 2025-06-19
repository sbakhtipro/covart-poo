<?php

namespace App\Router;

abstract class Router {

    public array $routes = [
        '' => [
            'model' => 'user/index',
            'template' => 'user/index',
        ],
        'passenger-index' => [
            'model' => 'user/passenger/index',
            'template' => 'user/passenger/index', 
        ],
        'driver-index' => [
            'model' => 'user/driver/index',
            'template' => 'user/driver/index', 
        ],
        'choose-address' => [
            'model' => 'user/driver/propose-commute/propose-commute',
            'template' => 'user/driver/propose-commute/choose-address', 
        ],
        'choose-times' => [
            'model' => 'user/driver/propose-commute/propose-commute',
            'template' => 'user/driver/propose-commute/choose-times', 
        ],
        'license-verify' => [
            'model' => 'user/license-verify',
            'template' => 'user/license-verify', 
        ],
        'login' => [
            'model' => 'user/login',
            'template' => 'user/login',
        ],
        'logout' => [
            'model' => 'user/logout',
        ],
        'profile' => [
            'model' => 'user/profile',
            'template' => 'user/profile',
        ],
        'user-account' => [
            'model' => 'user/user-account',
            'template' => 'user/user-account',
        ],
        'addresses' => [
            'model' => 'user/driver/propose-commute/addresses',
        ],
    ];
    
    public function run() {

    }

}