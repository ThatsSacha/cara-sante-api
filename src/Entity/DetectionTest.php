<?php

namespace App\Entity;

use App\Repository\DetectionTestRepository;
use Doctrine\ORM\Mapping as ORM;

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
     * @ORM\ManyToOne(targetEntity=Patient::class, inversedBy="detectionTests", cascade={"persist"})
     */
    private $patient;

    /**
     * @ORM\Column(type="datetime")
     */
    private $testedAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isInvoiced = false;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="detectionTests")
     */
    private $user;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $filledAt = false;

    public function jsonSerialize(): array {
        return array();
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

    public function getTestedAt(): ?\DateTimeInterface
    {
        return $this->testedAt;
    }

    public function setTestedAt(\DateTimeInterface $testedAt): self
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

    public function getFilledAt(): ?\DateTimeInterface
    {
        return $this->filledAt;
    }

    public function setFilledAt(?\DateTimeInterface $filledAt): self
    {
        $this->filledAt = $filledAt;

        return $this;
    }
}
