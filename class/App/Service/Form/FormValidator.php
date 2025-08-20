<?php

namespace App\Service\Form;

class FormValidator {

    private array $fieldsConditions = [];

    public function clearStepInSession($step): void {
        if (isset($_SESSION['form'][$step])) {
            unset($_SESSION['form'][$step]);
        }
    }

    private function setFieldsConditions(array $fieldsConditions) {
        $this->fieldsConditions = $fieldsConditions;
    }

    public function checkFieldsPost(array $fields): array|bool {
        $this->setFieldsConditions($fields);
        $errors = [];
        if (isset($_POST)) {
            foreach ($fields as $field => $conditions) {
                if (empty($_POST[$field])) {
                    $errors[$field] = 'Le champ ne peut pas être vide.';
                    continue;
                }
                if (!is_array($_POST[$field]) && isset($this->fieldsConditions[$field])) {
                    if (isset($this->fieldsConditions[$field]['min']) && isset($this->fieldsConditions[$field]['max'])) {
                        if ($this->fieldsConditions[$field]['type'] === 'string') {
                            if (strlen($_POST[$field]) <= $this->fieldsConditions[$field]['min'] || strlen($_POST[$field]) > $this->fieldsConditions[$field]['max']) {
                                $errors[$field] = "Le nombre de caractères est invalide.";
                            }
                        }
                        else if ($this->fieldsConditions[$field]['type'] === 'int') {
                            if ($_POST[$field] < $this->fieldsConditions[$field]['min'] || $_POST[$field] < $this->fieldsConditions[$field]['max']) {
                                $errors[$field] = "Le nombre doit être compris entre " . $this->fieldsConditions[$field]['min'] . " et " . $this->fieldsConditions[$field]['max'];
                            }
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

    private function sanitizeInput($key,$value): bool {
        switch ($this->fieldsConditions[$key]['type']) {
            case 'float':
                return filter_var($value, FILTER_VALIDATE_FLOAT);
            case 'int':
                return filter_var($value, FILTER_VALIDATE_INT);
            case 'mail':
                return filter_var($value, FILTER_VALIDATE_EMAIL);
            case 'string':
            default:
                $sanitizedValue = trim(strip_tags($value));
                return $sanitizedValue;
        }
    }

    public function saveStepData($formStep,$columns,$tokenCSRF=false): bool {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            foreach($columns as $column => $conditions) {
                $sanitizedInput = $this->sanitizeInput($column, $_POST[$column]);
                if ($sanitizedInput === false || $sanitizedInput === null) {
                    return false;
                } 
                $_SESSION['form'][$formStep][$column] = $_POST[$column];
            }
            if ($tokenCSRF) {
                $sanitizedToken = trim(strip_tags($_POST['token-csrf']));
                $_SESSION['form'][$formStep]['token-csrf'] = $sanitizedToken;
            }
            return true;
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