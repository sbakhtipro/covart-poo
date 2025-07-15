<?php

namespace App\Controller;

abstract class Controller {

    protected ?\App\Service\Form\FormValidator $formValidator;

    public function __construct() {
        $this->formValidator = new \App\Service\Form\FormValidator();
    }

    public function redirect($path) {
        header('Location:' . $path);
        exit;
    }

    public function render(string $path='', array $variables=[]) {
        extract($variables);
        if ($path!=='' && $path!=='user/login' && $path!=='user/license-verify') {
            require_once ROOT . '/view/partials/_header.html.php';
            require_once ROOT . '/view/' . $path . '.html.php';
            require_once ROOT . '/view/partials/_footer.html.php';
        }
        else if ($path==='user/login' || $path==='user/license-verify') {
            require_once ROOT . '/view/' . $path . '.html.php';
        }
    }

}