<?php

namespace App\Entity;

use App\Repository\SpellsIconsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SpellsIconsRepository::class)]
class SpellsIcons
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToOne(inversedBy: 'spellsIcons', cascade: ['persist', 'remove'])]
    private ?Abilities $ability = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAbility(): ?Abilities
    {
        return $this->ability;
    }

    public function setAbility(?Abilities $ability): self
    {
        $this->ability = $ability;

        return $this;
    }
}
