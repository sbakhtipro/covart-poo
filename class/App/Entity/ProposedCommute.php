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
    private ?bool $suppression = null;
    private ?\DateTime $suppressionTime = null;

    public function setId($id) {
        $this->id = $id;
    }
    public function getId() {
        return $this->id;
    }

    public function setArrivalPlace($arrivalPlace) {
        $this->arrivalPlace = $arrivalPlace;
    }
    public function getArrivalPlace() {
        return $this->arrivalPlace;
    }

    public function setArrivalPlaceLat($arrivalPlaceLat) {
        $this->arrivalPlaceLat = $arrivalPlaceLat;
    }
    public function getArrivalPlaceLat() {
        return $this->arrivalPlaceLat;
    }

    public function setArrivalPlaceLon($arrivalPlaceLon) {
        $this->arrivalPlaceLon = $arrivalPlaceLon;
    }
    public function getArrivalPlaceLon() {
        return $this->arrivalPlaceLon;
    }

    public function setDeparturePlace($departurePlace) {
        $this->departurePlace = $departurePlace;
    }
    public function getDeparturePlace() {
        return $this->departurePlace;
    }

    public function setDeparturePlaceLat($departurePlaceLat) {
        $this->departurePlaceLat = $departurePlaceLat;
    }
    public function getDeparturePlaceLat() {
        return $this->departurePlaceLat;
    }

    public function setDeparturePlaceLon($departurePlaceLon) {
        $this->departurePlaceLon = $departurePlaceLon;
    }
    public function getDeparturePlaceLon() {
        return $this->departurePlaceLon;
    }

    public function setDepartureTime($departureTime) {
        $this->departureTime = $departureTime;
    }
    public function getDepartureTime() {
        return $this->departureTime;
    }

    public function setSuppression($suppression) {
        $this->suppression = $suppression;
    }
    public function getSuppression() {
        return $this->suppression;
    }

    public function setSuppressionTime($suppressionTime) {
        $this->suppressionTime = $suppressionTime;
    }
    public function getSuppressionTime() {
        return $this->suppressionTime;
    }
}