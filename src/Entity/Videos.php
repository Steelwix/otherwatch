<?php

namespace App\Entity;

use App\Repository\VideosRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: VideosRepository::class)]
class Videos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'videos')]
    private ?Heroes $heroes = null;

    #[ORM\Column(length: 255)]
    private ?string $link = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getHeroes(): ?Heroes
    {
        return $this->heroes;
    }

    public function setHeroes(?Heroes $heroes): self
    {
        $this->heroes = $heroes;

        return $this;
    }

    public function getLink(): ?string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;

        return $this;
    }
}
