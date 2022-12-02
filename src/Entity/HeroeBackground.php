<?php

namespace App\Entity;

use App\Repository\HeroeBackgroundRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HeroeBackgroundRepository::class)]
class HeroeBackground
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'heroeBackground', cascade: ['persist', 'remove'])]
    private ?Heroes $heroe = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Medias $media = null;

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

    public function getMedia(): ?Medias
    {
        return $this->media;
    }

    public function setMedia(?Medias $media): self
    {
        $this->media = $media;

        return $this;
    }
}
