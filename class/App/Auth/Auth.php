<?php

namespace App\Auth;

class Auth {

    protected function redirect($path) {
        header('Location:' . $path);
        exit;
    }

}