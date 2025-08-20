<?php

namespace App\Entity;

class ProposedCommute {

    private $id;
    private string $arrivalPlace;
    private float $arrivalPlaceLat;
    private float $arrivalPlaceLon;
    private string $departurePlace;
    private float $departurePlaceLat;
    private float $departurePlaceLon;
    private \DateTime $departureTime;
    private ?bool $suppression = false;
    private ?\DateTime $suppressionTime = null;
    private $commuteTypeId;
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

    public function setArrivalPlace(string $arrivalPlace): void {
        $this->arrivalPlace = $arrivalPlace;
    }
    public function getArrivalPlace(bool $raw = false): string {
        if ($raw) {
            return $this->arrivalPlace;
        }
        return escapeForHtml($this->arrivalPlace);
    }

    public function setArrivalPlaceLat(float $arrivalPlaceLat): void {
        $this->arrivalPlaceLat = $arrivalPlaceLat;
    }
    public function getArrivalPlaceLat(): float {
        return $this->arrivalPlaceLat;
    }

    public function setArrivalPlaceLon(float $arrivalPlaceLon): void {
        $this->arrivalPlaceLon = $arrivalPlaceLon;
    }
    public function getArrivalPlaceLon(): float {
        return $this->arrivalPlaceLon;
    }

    public function setDeparturePlace(string $departurePlace): void {
        $this->departurePlace = $departurePlace;
    }
    public function getDeparturePlace(bool $raw = false): string {
        if ($raw) {
            return $this->departurePlace;
        }
        return escapeForHtml($this->departurePlace);
    }

    public function setDeparturePlaceLat(float $departurePlaceLat): void {
        $this->departurePlaceLat = $departurePlaceLat;
    }
    public function getDeparturePlaceLat(): float {
        return $this->departurePlaceLat;
    }

    public function setDeparturePlaceLon(float $departurePlaceLon): void {
        $this->departurePlaceLon = $departurePlaceLon;
    }
    public function getDeparturePlaceLon(): float {
        return $this->departurePlaceLon;
    }

    // FORMATTER GETTER /!\
    public function setDepartureTime(string $departureTime): void {
        $this->departureTime = new \DateTime($departureTime);
    }
    public function getDepartureTime(): \DateTime {
        return $this->departureTime;
    }

    public function setSuppression(bool $suppression = false): void {
        $this->suppression = $suppression;
    }
    public function getSuppression(): bool {
        return $this->suppression;
    }

    // FORMATTER GETTER /!\
    public function setSuppressionTime(?string $suppressionTime = null): void {
        $this->suppressionTime = new \DateTime($suppressionTime);
    }
    public function getSuppressionTime(): \DateTime {
        return $this->suppressionTime;
    }

    public function setCommuteTypeId($commuteTypeId): void {
        $this->commuteTypeId = $commuteTypeId;
    }
    public function getCommuteTypeId(bool $raw = false) {
        if ($raw) {
            return $this->commuteTypeId;
        }
        return escapeForHtml($this->commuteTypeId);
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