<?php

namespace App\Entity;

use App\Repository\DetectionTestRepository;
use DateTime;
use Doctrine\ORM\Mapping as ORM;
setlocale(LC_TIME, 'fr_FR');

/**
 * @ORM\Entity(repositoryClass=DetectionTestRepository::class)
 */
class DetectionTest
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $testedAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isInvoiced = false;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="detectionTests", cascade={"persist"})
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", nullable=true)
     */
    private $user = null;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $filledAt = null;

    /**
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="detectionTests", cascade={"persist"})
     * @ORM\JoinColumn(name="patient_id", referencedColumnName="id", nullable=false)
     */
    private $patient;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ref;

    public function jsonSerialize(): array {
        return array(
            'id' => $this->getId(),
            'patient' => $this->getPatient()->jsonSerializeLight(),
            'testedAt' => $this->getTestedAt(),
            'frenchTestedAt' => strftime('%A %d %B %G à %H:%M', strtotime(date_format($this->getTestedAt(), 'd/m/Y H:i:s'))),
            'isInvoiced' => $this->getIsInvoiced(),
            'filledAt' => $this->getFilledAt(),
            'patient' => $this->getPatient()->jsonSerializeLight(),
            'user' => $this->getUser() === null ? null : $this->getUser()->jsonSerializeLight()
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPatient(): ?Patient
    {
        return $this->patient;
    }

    public function setPatient(?Patient $patient): self
    {
        $this->patient = $patient;

        return $this;
    }

    public function getTestedAt(): ?DateTime
    {
        return $this->testedAt;
    }

    public function setTestedAt(DateTime $testedAt): self
    {
        $this->testedAt = $testedAt;

        return $this;
    }

    public function getIsInvoiced(): ?bool
    {
        return $this->isInvoiced;
    }

    public function setIsInvoiced(bool $isInvoiced): self
    {
        $this->isInvoiced = $isInvoiced;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getFilledAt(): ?DateTime
    {
        return $this->filledAt;
    }

    public function setFilledAt(?DateTime $filledAt): self
    {
        $this->filledAt = $filledAt;

        return $this;
    }

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef(string $ref): self
    {
        $this->ref = $ref;

        return $this;
    }
}
