<?php

namespace App\Entity;

use App\Repository\UpdateTicketRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UpdateTicketRepository::class)]
class UpdateTicket
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'ticket')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Heroes $heroe = null;

    #[ORM\ManyToOne(inversedBy: 'author')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Users $author = null;

    #[ORM\Column(length: 2000)]
    private ?string $content = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $date = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeroe(): ?Heroes
    {
        return $this->heroe;
    }

    public function setHeroe(?Heroes $heroe): self
    {
        $this->heroe = $heroe;

        return $this;
    }

    public function getAuthor(): ?Users
    {
        return $this->author;
    }

    public function setAuthor(?Users $author): self
    {
        $this->author = $author;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(?\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
