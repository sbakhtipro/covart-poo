<?php

namespace App\Entity;

class Status {

    private $id;
    private ?string $name;

    public function setId($id): void {
        $this->id = $id;
    }
    public function getId(bool $raw = false) {
        if ($raw) {
            return $this->id;
        }
        return escapeForHtml($this->id);
    }

    public function setName(?string $name): void {
        $this->name = $name;
    }
    public function getName(bool $raw = false): ?string {
        if ($raw) {
            return $this->name;
        }
        return escapeForHtml($this->name);
    }

}