<?php

namespace App\Entity;

class Users {

    private $id;
    private ?string $address;
    private ?float $addressLat;
    private ?float $addressLon;
    private ?string $phoneNumber;
    private string $mail;
    private string $password;
    private ?bool $licenseVerified;
    private ?bool $status;
    private ?string $description;
    private $roleId;

    public function setId($id): void {
        $this->id = $id;
    }
    public function getId(bool $raw = false) {
        if ($raw) {
            return $this->id;
        }
        return escapeForHtml($this->id);
    }

    public function setAddress(?string $address): void {
        $this->address = $address;
    }
    public function getAddress(bool $raw = false): ?string {
        if ($raw) {
            return $this->address;
        }
        return escapeForHtml($this->address);
    }

    public function setAddressLat(?float $addressLat): void {
        $this->addressLat = $addressLat;
    }
    public function getAddressLat(): ?float {
        return $this->addressLat;
    }

    public function setAddressLon(?float $addressLon): void {
        $this->addressLon = $addressLon;
    }
    public function getAddressLon(): ?float {
        return $this->addressLon;
    }

    public function setPhoneNumber(?string $phoneNumber): void {
        $this->phoneNumber = $phoneNumber;
    }
    public function getPhoneNumber(bool $raw = false): ?string {
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

    public function setPassword(string $password): void {
        $this->password = $password;
    }
    public function getPassword(bool $raw = false): string {
        if ($raw) {
            return $this->password;
        }
        return escapeForHtml($this->password);
    }

    public function setLicenseVerified(bool $licenseVerified = false): void {
        $this->licenseVerified = $licenseVerified;
    }
    public function getLicenseVerified(): bool {
        return $this->licenseVerified;
    }

    public function setStatus(bool $status = false): void {
        $this->status = $status;
    }
    public function getStatus(): bool {
        return $this->status;
    }

    public function setDescription(?string $description): void {
        $this->description = $description;
    }
    public function getDescription(bool $raw = false): ?string {
        if ($raw) {
            return $this->description;
        }
        return escapeForHtml($this->description);
    }

    public function setRoleId($roleId): void {
        $this->roleId = $roleId;
    }
    public function getRoleId(bool $raw = false) {
        if ($raw) {
            return $this->roleId;
        }
        return escapeForHtml($this->roleId);
    }

}