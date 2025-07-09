<?php

namespace App\Entity;

class Employees {

    private $id;
    private ?string $name;
    private ?string $prenom;
    private ?string $birthDate;
    private ?string $streetNumber;
    private ?string $street;
    private ?string $postalCode;
    private ?string $city;
    private ?string $phoneNumber;
    private ?string $mail;
    private ?string $registrationNumber;
    private ?\DateTime $hireDate;
    private ?string $status;
    private ?bool $isManager;
    private $positionId;
    
    public function setId($id): void {
        $this->id = $id;
    }
    public function getId(bool $raw = false) {
        if ($raw) {
            return $this->id;
        }
        return escapeForHtml($this->id);
    }

    public function setName(string $name): void {
        $this->name = $name;
    }
    public function getName(bool $raw = false): string {
        if ($raw) {
            return $this->name;
        }
        return escapeForHtml($this->name);
    }

    public function setPrenom(string $prenom): void {
        $this->prenom = $prenom;
    }
    public function getPrenom(bool $raw = false): string {
        if ($raw) {
            return $this->prenom;
        }
        return escapeForHtml($this->prenom);
    }
    
    public function setBirthDate(string $birthDate): void {
        $this->birthDate = $birthDate;
    }
    public function getBirthDate(bool $raw = false): string {
        if ($raw) {
            return $this->birthDate;
        }
        return escapeForHtml($this->birthDate);
    }

    public function setStreetNumber(string $streetNumber): void {
        $this->streetNumber = $streetNumber;
    }
    public function getStreetNumber(bool $raw = false): string {
        if ($raw) {
            return $this->streetNumber;
        }
        return escapeForHtml($this->streetNumber);
    }

    public function setStreet(string $street): void {
        $this->street = $street;
    }
    public function getStreet(bool $raw = false): string {
        if ($raw) {
            return $this->street;
        }
        return escapeForHtml($this->street);
    }
    
    public function setPostalCode(string $postalCode): void {
        $this->postalCode = $postalCode;
    }
    public function getPostalCode(bool $raw = false): string {
        if ($raw) {
            return $this->postalCode;
        }
        return escapeForHtml($this->postalCode);
    }

    public function setCity(string $city): void {
        $this->city = $city;
    }
    public function getCity(bool $raw = false): string {
        if ($raw) {
            return $this->city;
        }
        return escapeForHtml($this->city);
    }

    public function setPhoneNumber(string $phoneNumber): void {
        $this->phoneNumber = $phoneNumber;
    }
    public function getPhoneNumber(bool $raw = false): string {
        if ($raw) {
            return $this->phoneNumber;
        }
        return escapeForHtml($this->phoneNumber);
    }

    public function setMail(string $mail): void {
        $this->mail = $mail;
    }
    public function getMail(bool $raw = false): string {
        if ($raw) {
            return $this->mail;
        }
        return escapeForHtml($this->mail);
    }

    public function setRegistrationNumber(string $registrationNumber): void {
        $this->registrationNumber = $registrationNumber;
    }
    public function getRegistrationNumber(bool $raw = false): string {
        if ($raw) {
            return $this->registrationNumber;
        }
        return escapeForHtml($this->registrationNumber);
    }

    public function setHireDate(string $hireDate): void {
        $this->hireDate = new \DateTime($hireDate);
    }
    public function getHireDate():\DateTime {
        return $this->hireDate;
    }

    public function setStatus(string $status): void {
        $this->status = $status;
    }
    public function getStatus(bool $raw = false): string {
        if ($raw) {
            return $this->status;
        }
        return escapeForHtml($this->status);
    }

    public function setIsManager(bool $isManager): void {
        $this->isManager = $isManager;
    }
    public function getIsManager():bool {
        return $this->isManager;
    }

    public function setPositionId($positionId): void {
        $this->positionId = $positionId;
    }
    public function getPositionId(bool $raw = false) {
        if ($raw) {
            return $this->positionId;
        }
        return escapeForHtml($this->positionId);
    }

}