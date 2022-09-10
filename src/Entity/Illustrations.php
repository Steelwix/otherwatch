<?php

namespace App\Entity;

use App\Repository\IllustrationsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: IllustrationsRepository::class)]
class Illustrations
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'illustrations', cascade: ['persist', 'remove'])]
    private ?Heroes $heroes = null;

    #[ORM\ManyToOne(inversedBy: 'illustrations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Medias $medias = null;

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

    public function getMedias(): ?Medias
    {
        return $this->medias;
    }

    public function setMedias(?Medias $medias): self
    {
        $this->medias = $medias;

        return $this;
    }
}
