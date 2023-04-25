<?php

namespace App\Entity;

use IntlDateFormatter;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\SearchRepository;

/**
 * @ORM\Entity(repositoryClass=SearchRepository::class)
 */
class Search
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
    private $searchedBy;

    /**
     * @ORM\Column(type="datetime")
     */
    private $searchedAt;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $subject;

    /**
     * @return array
     */
    public function jsonSerialize(): array {
        return array(
            'id' => $this->getId(),
            'searchedAtFrench' => IntlDateFormatter::formatObject($this->getSearchedAt(), IntlDateFormatter::RELATIVE_MEDIUM, 'fr'),
            'subject' => $this->getSubject()
        );
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSearchedBy(): ?Users
    {
        return $this->searchedBy;
    }

    public function setSearchedBy(?Users $searchedBy): self
    {
        $this->searchedBy = $searchedBy;

        return $this;
    }

    public function getSearchedAt(): ?\DateTimeInterface
    {
        return $this->searchedAt;
    }

    public function setSearchedAt(\DateTimeInterface $searchedAt): self
    {
        $this->searchedAt = $searchedAt;

        return $this;
    }

    public function getSubject(): ?string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): self
    {
        $this->subject = $subject;

        return $this;
    }
}
