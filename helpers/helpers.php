<?php
 
function escapeForHtml($str) {
    if ($str === null) {
        return "";
    }
    return htmlspecialchars($str);
}

function redirect($path) {
    header('Location:' . $path);
    exit;
}