<?php

namespace App\Entity;

class Positions {

    private $id;
    private ?string $name;
    private $serviceId;

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

    public function setServiceId($serviceId): void {
        $this->serviceId = $serviceId;
    }
    public function getServiceId(bool $raw = false) {
        if ($raw) {
            return $this->serviceId;
        }
        return escapeForHtml($this->serviceId);
    }

}