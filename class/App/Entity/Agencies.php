<?php

namespace App\Entity;

class Agencies {

    private $id;
    private ?string $name;
    private ?string $siret;
    private ?string $type;
    private ?string $phoneNumber;
    private ?string $mail;
    private ?string $city;
    private ?string $postalCode;
    private ?string $streetNumber;
    private ?string $street;
    private ?float $lon;
    private ?float $lat;

    
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

    public function setSiret(string $siret): void {
        $this->siret = $siret;
    }
    public function getSiret(bool $raw = false): string {
        if ($raw) {
            return $this->siret;
        }
        return escapeForHtml($this->siret);
    }
    
    public function setType(string $type): void {
        $this->type = $type;
    }
    public function getType(bool $raw = false): string {
        if ($raw) {
            return $this->type;
        }
        return escapeForHtml($this->type);
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

    public function setCity(string $city): void {
        $this->city = $city;
    }
    public function getCity(bool $raw = false): string {
        if ($raw) {
            return $this->city;
        }
        return escapeForHtml($this->city);
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
    
    public function setLat(float $lat): void {
        $this->lat = $lat;
    }
    public function getLat(): float {
        return $this->lat;
    }

    public function setLon(float $lon): void {
        $this->lon = $lon;
    }
    public function getLon(): float {
        return $this->lon;
    }

}