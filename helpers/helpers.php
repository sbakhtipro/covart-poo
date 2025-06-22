<?php
 
function escapeForHtml($str) {
    if ($str === null) {
        return "";
    }
    return htmlspecialchars($str);
}
