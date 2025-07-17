<?php

namespace App\Service\Form;

class FormValidator {

    // public function checkFieldsPost(array $fields): bool {
    //     foreach ($fields as $field) {
    //         if (is_array($field)) {
    //             foreach ($field as $fieldElement) {
    //                 if (empty($_POST[$fieldElement])) {
    //                     return false;
    //                 }
    //             }
    //         }
    //         else if (empty($_POST[$field])) {
    //             return false;
    //         }
    //     }
    //     return true;
    // }

    public array $fieldsConditions = [];

    public function __construct() {
        $this->fieldsConditions = [
            'trajet_lieu_arrivee' => [
                'min-length' => 3,
                'max-length' => 50,
                'type' => 'string'
            ],
            'trajet_lieu_arrivee_lat' => [
                'type' => 'float'
            ],
            'trajet_lieu_arrivee_lon' => [
                'type' => 'float'
            ],
            'trajet_lieu_depart' => [
                'min-length' => 3,
                'max-length' => 50,
                'type' => 'string'
            ],
            'trajet_lieu_depart_lat' => [
                'type' => 'float'
            ],
            'trajet_lieu_depart_lon' => [
                'type' => 'float'
            ],
            'trajet_heure_depart' => [
                'type' => 'string'
            ],
            'trajet_nb_places' => [
                'type' => 'int'
            ],
            'type_trajet_id' => [
                'type' => 'int'
            ],
            'vehicule_id' => [
                'type' => 'int'
            ]
        ];
    }

    public function clearStepInSession($step): void {
        if (isset($_SESSION['form'][$step])) {
            unset($_SESSION['form'][$step]);
        }
    }

    public function checkFieldsPost(array $fields): array|bool {
        // var_dump($fields);
        // var_dump($_POST['trajet_date_heure_depart']);
        // exit;
        $errors = [];
        if (isset($_POST)) {
            foreach ($fields as $field) {
                if (empty($_POST[$field])) {
                    $errors[$field] = 'Le champ ne peut pas être vide.';
                    continue;
                }
                if (!is_array($_POST[$field]) && isset($this->fieldsConditions[$field])) {
                    if (isset($this->fieldsConditions[$field]['min-length']) && isset($this->fieldsConditions[$field]['max-length'])) {
                        if (strlen($_POST[$field]) <= $this->fieldsConditions[$field]['min-length'] || strlen($_POST[$field]) > $this->fieldsConditions[$field]['max-length']) {
                            $errors[$field] = 'Le nombre de caractères est invalide.';
                        }
                    }
                }
            }
            if (!empty($errors)) {
                return $errors;
            }
        }
        return true;
    }

    private function sanitizeInput($key,$value): mixed {
        switch ($this->fieldsConditions[$key]['type']) {
            case 'float':
                $sanitizedInput = filter_var($value, FILTER_SANITIZE_NUMBER_FLOAT);
                return filter_var($sanitizedInput, FILTER_VALIDATE_FLOAT);
            case 'int':
                $sanitizedInput = filter_var($value, FILTER_SANITIZE_NUMBER_INT);
                return filter_var($sanitizedInput, FILTER_VALIDATE_INT);
            case 'mail':
                $sanitizedInput = filter_var($value, FILTER_SANITIZE_EMAIL);
                return filter_var($sanitizedInput, FILTER_VALIDATE_EMAIL);
            default:
                return filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }
    }

    public function saveStepData($formStep,$columns,$tokenCSRF=false): bool {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST)) {
                foreach($columns as $column) {
                    $sanitizedInput = $this->sanitizeInput($column, $_POST[$column]);
                    $_SESSION['form'][$formStep][$column] = $sanitizedInput;
                }
                if ($tokenCSRF) {
                    $_SESSION['form'][$formStep]['token-csrf'] = $_POST['token-csrf'];
                }
                return true;
            }
        }
        return false;
    }

    public function checkStep($formStep): bool {
        if (isset($_SESSION['form'][$formStep])) {
            foreach ($_SESSION['form'][$formStep] as $column) {
                if (empty($column)) {
                    return false;
                }
            }
        }
        return true;
    }

}