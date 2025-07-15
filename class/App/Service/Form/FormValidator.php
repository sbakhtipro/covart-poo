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
    public array $errors = [];

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
        if (isset($_SESSION[$step])) {
            unset($_SESSION[$step]);
        }
    }

    public function checkFieldsPost(array $fields) {
        foreach ($fields as $field) {
            if (empty($_POST[$field])) {
                return false;
            }
            if (!is_array($_POST[$field]) && isset($this->fieldsConditions[$field])) {
                if (strlen($field) <= $this->fieldsConditions[$field]['min-length'] || strlen($field) > $this->fieldsConditions[$field]['max-length']) {
                    array_push($errors,[$field => 'Le nombre de caractères est invalide.']);
                }
            }
        }
        if (!empty($errors)) {
            return $errors;
        }
        return true;
    }

    private function sanitizeInputs($input) {
        switch ($this->fieldsConditions[$input]['type']) {
            case 'float':
                $sanitizedInput = filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT);
                return filter_var($sanitizedInput, FILTER_VALIDATE_FLOAT);
            case 'int':
                $sanitizedInput = filter_var($input, FILTER_SANITIZE_NUMBER_INT);
                return filter_var($sanitizedInput, FILTER_VALIDATE_INT);
            case 'mail':
                $sanitizedInput = filter_var($input, FILTER_SANITIZE_EMAIL);
                return filter_var($sanitizedInput, FILTER_VALIDATE_EMAIL);
            default:
                return filter_var($input, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        }
    }

    public function saveStepData() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            
        }
    }

}