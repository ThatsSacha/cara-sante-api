<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass=UsersRepository::class)
 */
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     */
    private $email;

    /**
     * @ORM\Column(type="json")
     */
    private $roles = ["ROLE_USER"];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastName;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\OneToMany(targetEntity=DetectionTest::class, mappedBy="user")
     */
    private $detectionTests;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phone;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="users")
     */
    private $createdBy;

    /**
     * @ORM\OneToMany(targetEntity=Users::class, mappedBy="createdBy")
     */
    private $users;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isFirstConnection = true;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $token;

    public function __construct()
    {
        $this->detectionTests = new ArrayCollection();
        $this->users = new ArrayCollection();
    }

    public function jsonSerialize(): array {
        return array(
            'id' => $this->getId(),
            'firstName' => $this->getFirstName(),
            'lastName' => $this->getLastName(),
            'mail' => $this->getEmail(),
            'phone' => $this->getPhone(),
            'roles' => $this->getRoles(),
            'createdAt' => date_format($this->getCreatedAt(), 'd/m/Y H:s'),
            'createdAtFrench' => $this->getCreatedAt() !== null ? strftime('%A %d %B %G à %H:%M', strtotime(date_format($this->getCreatedAt(), 'Y-m-d H:i:s'))) : null,
            'createdBy' => $this->getCreatedBy() !== null ? $this->getCreatedBy()->jsonSerializeLight() : null,
            'isFirstConnection' => $this->getIsFirstConnection(),
            'detectionTests' => $this->getDetectionTestsSerialized()
        );
    }

    public function jsonSerializeLight(): array {
        return array(
            'id' => $this->getId(),
            'firstName' => $this->getFirstName(),
            'lastName' => $this->getLastName(),
            'mail' => $this->getEmail(),
            'roles' => $this->getRoles()
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string
    {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @return Collection|DetectionTest[]
     */
    public function getDetectionTests(): Collection
    {
        return $this->detectionTests;
    }

    public function getDetectionTestsSerialized(): array {
        $detectionTests = $this->getDetectionTests();
        $detectionTestsSerialized = [];

        foreach($detectionTests as $detectionTest) {
            $detectionTestsSerialized[] = $detectionTest->jsonSerializeLight();
        }

        return $detectionTestsSerialized;
    }

    public function addDetectionTest(DetectionTest $detectionTest): self
    {
        if (!$this->detectionTests->contains($detectionTest)) {
            $this->detectionTests[] = $detectionTest;
            $detectionTest->setUser($this);
        }

        return $this;
    }

    public function removeDetectionTest(DetectionTest $detectionTest): self
    {
        if ($this->detectionTests->removeElement($detectionTest)) {
            // set the owning side to null (unless already changed)
            if ($detectionTest->getUser() === $this) {
                $detectionTest->setUser(null);
            }
        }

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

    public function getCreatedBy(): ?self
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?self $createdBy): self
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    /**
     * @return Collection|self[]
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(self $user): self
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
            $user->setCreatedBy($this);
        }

        return $this;
    }

    public function removeUser(self $user): self
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getCreatedBy() === $this) {
                $user->setCreatedBy(null);
            }
        }

        return $this;
    }

    public function getIsFirstConnection(): ?bool
    {
        return $this->isFirstConnection;
    }

    public function setIsFirstConnection(bool $isFirstConnection): self
    {
        $this->isFirstConnection = $isFirstConnection;

        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(string|null $token): self
    {
        $this->token = $token;

        return $this;
    }
}
