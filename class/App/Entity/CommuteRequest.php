<?php

namespace App\Entity;

class CommuteRequest {

    private $id;
    private ?\DateTime $requestDate;
    private ?\DateTime $agreementDate;
    private $statusId;
    private $commuteId;
    private $employeeId;

    public function setId($id): void {
        $this->id = $id;
    }
    public function getId($id) {
        return $this->id;
    }

    public function setRequestDate($requestDate): void {
        $this->requestDate = $requestDate;
    }
    public function getRequestDate($requestDate) {
        return $this->requestDate;
    }

    public function setAgreementDate($agreementDate): void {
        $this->agreementDate = $agreementDate;
    }
    public function getAgreementDate($agreementDate) {
        return $this->agreementDate;
    }

    public function setStatusId($statusId): void {
        $this->statusId = $statusId;
    }
    public function getStatusId(bool $raw = false) {
        if ($raw) {
            return $this->statusId;
        }
        return escapeForHtml($this->statusId);
    }

    public function setCommuteId($commuteId): void {
        $this->commuteId = $commuteId;
    }
    public function getCommuteId(bool $raw = false) {
        if ($raw) {
            return $this->commuteId;
        }
        return escapeForHtml($this->commuteId);
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