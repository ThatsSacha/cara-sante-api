<?php

namespace App\Entity;

use App\Repository\SearchRepository;
use Doctrine\ORM\Mapping as ORM;

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
            'searchedAtFrench' => utf8_encode(strftime('%A %d %B %G - %H:%M', strtotime(date_format($this->getSearchedAt(), 'Y-m-d H:i:s')))),
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
