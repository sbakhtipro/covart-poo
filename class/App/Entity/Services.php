<?php

namespace App\Entity;

class Services {

    private $id;
    private ?string $name;
    private $agencyId;

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
    public function getName(bool $raw = false) {
        if ($raw) {
            return $this->name;
        }
        return escapeForHtml($this->name);
    }

    public function setAgencyId($agencyId): void {
        $this->agencyId = $agencyId;
    }
    public function getAgencyId(bool $raw = false) {
        if ($raw) {
            return $this->agencyId;
        }
        return escapeForHtml($this->agencyId);
    }

}