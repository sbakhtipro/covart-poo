<?php

namespace App\Entity;

class CommuteRequest {

    private $id;
    private \DateTime $requestDate;
    private ?\DateTime $agreementDate;

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

}