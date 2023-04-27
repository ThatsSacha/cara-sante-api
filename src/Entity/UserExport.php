<?php

namespace App\Entity;

use IntlDateFormatter;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserExportRepository;

/**
 * @ORM\Entity(repositoryClass=UserExportRepository::class)
 */
class UserExport
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $requestedBy;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="userExports")
     * @ORM\JoinColumn(nullable=false)
     */
    private $dataFrom;

    /**
     * @ORM\Column(type="datetime")
     */
    private $requestedAt;

    /**
     * @ORM\Column(type="text")
     */
    private $fileName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ref;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $requestedPeriod;

    public function jsonSerialize(): array {
        $requestedAt = $this->getRequestedAt() === null ? : IntlDateFormatter::formatObject($this->getRequestedAt(), IntlDateFormatter::RELATIVE_MEDIUM, 'fr');

        return array(
            'ref' => $this->getRef(),
            'requestedBy' => $this->getRequestedBy()->jsonSerializeUltraLight(),
            'dataFrom' => $this->getDataFrom()->jsonSerializeUltraLight(),
            'requestedAt' => $requestedAt,
            'fileName' => $this->getFileName(),
            'requestedPeriod' => $this->getRequestedPeriod()
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRequestedBy(): ?Users
    {
        return $this->requestedBy;
    }

    public function setRequestedBy(?Users $requestedBy): self
    {
        $this->requestedBy = $requestedBy;

        return $this;
    }

    public function getDataFrom(): ?Users
    {
        return $this->dataFrom;
    }

    public function setDataFrom(?Users $dataFrom): self
    {
        $this->dataFrom = $dataFrom;

        return $this;
    }

    public function getRequestedAt(): ?\DateTimeInterface
    {
        return $this->requestedAt;
    }

    public function setRequestedAt(\DateTimeInterface $requestedAt): self
    {
        $this->requestedAt = $requestedAt;

        return $this;
    }

    public function getFileName(): ?string
    {
        return $this->fileName;
    }

    public function setFileName(string $fileName): self
    {
        $this->fileName = $fileName;

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

    public function getRequestedPeriod(): ?string
    {
        return $this->requestedPeriod;
    }

    public function setRequestedPeriod(string $requestedPeriod): self
    {
        $this->requestedPeriod = $requestedPeriod;

        return $this;
    }
}
