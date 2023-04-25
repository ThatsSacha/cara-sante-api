<?php

namespace App\Entity;

use DateTime;
use IntlDateFormatter;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\DetectionTestRepository;
setlocale(LC_TIME, 'fr_FR');

/**
 * @ORM\Entity(repositoryClass=DetectionTestRepository::class)
 * @ORM\Table(indexes={@ORM\Index(columns={"ref"})})
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

    /**
     * @ORM\Column(type="boolean")
     */
    private $isUpdating = false;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class)
     */
    private $updatingBy;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $isNegative;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $startUpdating;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $doctorFirstName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $doctorLastName;

    public function jsonSerialize(): array {
        $frenchTestedAt = IntlDateFormatter::formatObject($this->getTestedAt(), IntlDateFormatter::RELATIVE_MEDIUM, 'fr');
        $filledAtFrench = $this->getFilledAt() === null ? : IntlDateFormatter::formatObject($this->getFilledAt(), IntlDateFormatter::RELATIVE_MEDIUM, 'fr');

        return array(
            'id' => $this->getId(),
            'ref' => $this->getRef(),
            'patient' => $this->getPatient() !== null ? $this->getPatient()->jsonSerializeLight() : null,
            'testedAt' => $this->getTestedAt(),
            'isNegative' => $this->getIsNegative(),
            'frenchTestedAt' => $frenchTestedAt,
            'isInvoiced' => $this->getIsInvoiced(),
            'filledAt' => $this->getFilledAt(),
            'filledAtFrench' => $this->getFilledAt() !== null ? $filledAtFrench : null,
            'user' => $this->getUser() === null ? null : $this->getUser()->jsonSerializeLight(),
            'isUpdating' => $this->getIsUpdating(),
            'updatingBy' => $this->getUpdatingBy() !== null ? $this->getUpdatingBy()->jsonSerializeLight() : null,
            'doctorFirstName' => $this->getDoctorFirstName(),
            'doctorLastName' => $this->getDoctorLastName()
        );
    }

    public function jsonSerializeLight(): array {
        $frenchTestedAt = IntlDateFormatter::formatObject($this->getTestedAt(), IntlDateFormatter::RELATIVE_MEDIUM, 'fr');
        $filledAtFrench = $this->getFilledAt() === null ? : IntlDateFormatter::formatObject($this->getFilledAt(), IntlDateFormatter::RELATIVE_MEDIUM, 'fr');

        return array(
            'id' => $this->getId(),
            'ref' => $this->getRef(),
            'patient' => $this->getPatient() !== null ? $this->getPatient()->jsonSerializeLight() : null,
            'testedAt' => $this->getTestedAt(),
            'isNegative' => $this->getIsNegative(),
            'frenchTestedAt' => $frenchTestedAt,
            'isInvoiced' => $this->getIsInvoiced(),
            'filledAt' => $this->getFilledAt(),
            'filledAtFrench' => $this->getFilledAt() !== null ? $filledAtFrench : null,
            'isUpdating' => $this->getIsUpdating(),
            'updatingBy' => $this->getUpdatingBy() !== null ? $this->getUpdatingBy()->jsonSerializeLight() : null,
            'doctorFirstName' => $this->getDoctorFirstName(),
            'doctorLastName' => $this->getDoctorLastName()
        );
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
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

    public function getIsUpdating(): ?bool
    {
        return $this->isUpdating;
    }

    public function setIsUpdating(bool $isUpdating): self
    {
        $this->isUpdating = $isUpdating;

        return $this;
    }

    public function getUpdatingBy(): ?Users
    {
        return $this->updatingBy;
    }

    public function setUpdatingBy(?Users $updatingBy): self
    {
        $this->updatingBy = $updatingBy;

        return $this;
    }

    public function getIsNegative(): ?bool
    {
        return $this->isNegative;
    }

    public function setIsNegative(?bool $isNegative): self
    {
        $this->isNegative = $isNegative;

        return $this;
    }

    public function getStartUpdating(): ?\DateTimeInterface
    {
        return $this->startUpdating;
    }

    public function setStartUpdating(?\DateTimeInterface $startUpdating): self
    {
        $this->startUpdating = $startUpdating;

        return $this;
    }

    public function getDoctorFirstName(): string|null
    {
        return $this->doctorFirstName;
    }

    public function setDoctorFirstName(string|null $doctorFirstName): self
    {
        $this->doctorFirstName = $doctorFirstName;

        return $this;
    }

    public function getDoctorLastName(): string|null
    {
        return $this->doctorLastName;
    }

    public function setDoctorLastName(string|null $doctorLastName): self
    {
        $this->doctorLastName = $doctorLastName;

        return $this;
    }
}
