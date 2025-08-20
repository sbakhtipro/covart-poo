<?php

namespace Core\Service;

class ExportJSON {
    // si problème vérifier si pas de var dump dans les classes impliquées et leurs parents!!
    public function exportData($recordset) {
        header('Content-Type: application/json');
        echo json_encode($recordset);
        // exit;
    }
}