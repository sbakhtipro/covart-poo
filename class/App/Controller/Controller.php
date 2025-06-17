<?php

namespace App\Controller;

class Controller {

    public function render(string $path='', array $variables=[]) {
        extract($variables);
        if ($path!=='' && $path!=='login') {
            require_once ROOT . 'view/partials/_header.html.php';
            require_once ROOT . 'view/' . $path . '.html.php';
            require_once ROOT . 'view/partials/_footer.html.php';
        }
        else if ($path==='login') {
            require_once ROOT . 'view/' . $path . '.html.php';
        }
    }

}