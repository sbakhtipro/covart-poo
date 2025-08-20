<?php

namespace App\Entity;

class Vehicles {

    private $id;
    private ?string $registrationPlate;
    private $vehicleModelId;
    private $employeeId;

    public function setId($id): void {
        $this->id = $id;
    }
    public function getId(bool $raw = false) {
        if ($raw) {
            return $this->id;
        }
        return escapeForHtml($this->id);
    }

    public function setRegistrationPlate(?string $registrationPlate): void {
        $this->registrationPlate = $registrationPlate;
    }
    public function getRegistrationPlate(bool $raw = false): ?string {
        if ($raw) {
            return $this->registrationPlate;
        }
        return escapeForHtml($this->registrationPlate);
    }

    public function setVehicleModelId($vehicleModelId): void {
        $this->vehicleModelId = $vehicleModelId;
    }
    public function getVehicleModelId(bool $raw = false) {
        if ($raw) {
            return $this->vehicleModelId;
        }
        return escapeForHtml($this->vehicleModelId);
    }

    public function setEmployeeId($employeeId): void {
        $this->employeeId = $employeeId;
    }
    public function getEmployeeId(bool $raw = false) {
        if ($raw) {
            return $this->employeeId;
        }
        return escapeForHtml($this->employeeId);
    }

}