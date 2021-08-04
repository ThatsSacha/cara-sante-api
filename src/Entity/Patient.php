<?php

namespace App\Entity;

use App\Repository\PatientRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
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
     * @ORM\OneToMany(targetEntity=DetectionTest::class, mappedBy="patient")
     */
    private $detectionTests;

    public function __construct()
    {
        $this->detectionTests = new ArrayCollection();
    }

    public function jsonSerialize(): array {
        return array(
            'id' => $this->getId(),
            'firstName' => $this->getFirstName(),
            'lastName' => $this->getLastName(),
            'mail' => $this->getMail(),
            'phone' => $this->getPhone(),
            'birth' => $this->getBirth(),
            'street' => $this->getStreet(),
            'zip' => $this->getZip(),
            'city' => $this->getCity(),
            'nir' => $this->getNir(),
            'tests' => $this->getDetectionTests() !== null ? null : $this->getDetectionTests()->jsonSerialize()
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

    /**
     * @return Collection|DetectionTest[]
     */
    public function getDetectionTests(): Collection
    {
        return $this->detectionTests;
    }

    public function addDetectionTest(DetectionTest $detectionTest): self
    {
        if (!$this->detectionTests->contains($detectionTest)) {
            $this->detectionTests[] = $detectionTest;
            $detectionTest->setPatient($this);
        }

        return $this;
    }

    public function removeDetectionTest(DetectionTest $detectionTest): self
    {
        if ($this->detectionTests->removeElement($detectionTest)) {
            // set the owning side to null (unless already changed)
            if ($detectionTest->getPatient() === $this) {
                $detectionTest->setPatient(null);
            }
        }

        return $this;
    }
}
