<?php

namespace App\Entity;

use App\Repository\AbilitiesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AbilitiesRepository::class)]
class Abilities
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'abilities')]
    private ?Heroes $heroes = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 10000, nullable: true)]
    private ?string $description = null;

    #[ORM\OneToOne(mappedBy: 'ability', cascade: ['persist', 'remove'])]
    private ?SpellsIcons $spellsIcons = null;

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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getSpellsIcons(): ?SpellsIcons
    {
        return $this->spellsIcons;
    }

    public function setSpellsIcons(?SpellsIcons $spellsIcons): self
    {
        // unset the owning side of the relation if necessary
        if ($spellsIcons === null && $this->spellsIcons !== null) {
            $this->spellsIcons->setAbility(null);
        }

        // set the owning side of the relation if necessary
        if ($spellsIcons !== null && $spellsIcons->getAbility() !== $this) {
            $spellsIcons->setAbility($this);
        }

        $this->spellsIcons = $spellsIcons;

        return $this;
    }
}
