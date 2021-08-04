<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PatientRepository::class)
 */
class Patient
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mail;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\Column(type="date")
     */
    private $birth;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $zip;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $nir;

    /**
     * @ORM\Column(type="datetime")
     */
    private $testedAt;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isFilled = false;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isInvoiced = false;

    public function jsonSerialize(): array {
        return array(
            'id' => $this->getId(),
            'mail' => $this->getMail()
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(string $phone): self
    {
        $this->phone = $phone;

        return $this;
    }

    public function getBirth(): ?\DateTimeInterface
    {
        return $this->birth;
    }

    public function setBirth(\DateTimeInterface $birth): self
    {
        $this->birth = $birth;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getZip(): ?string
    {
        return $this->zip;
    }

    public function setZip(string $zip): self
    {
        $this->zip = $zip;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getNir(): ?string
    {
        return $this->nir;
    }

    public function setNir(string $nir): self
    {
        $this->nir = $nir;

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

    public function getIsFilled(): ?bool
    {
        return $this->isFilled;
    }

    public function setIsFilled(bool $isFilled): self
    {
        $this->isFilled = $isFilled;

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
}
