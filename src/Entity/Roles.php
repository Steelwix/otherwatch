<?php

namespace App\Entity;

use App\Repository\RolesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RolesRepository::class)]
class Roles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'role', targetEntity: Heroes::class)]
    private Collection $heroes;

    #[ORM\OneToOne(mappedBy: 'role', cascade: ['persist', 'remove'])]
    private ?RoleIcon $roleIcon = null;

    public function __construct()
    {
        $this->heroes = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Heroes>
     */
    public function getHeroes(): Collection
    {
        return $this->heroes;
    }

    public function addHero(Heroes $hero): self
    {
        if (!$this->heroes->contains($hero)) {
            $this->heroes->add($hero);
            $hero->setRole($this);
        }

        return $this;
    }

    public function removeHero(Heroes $hero): self
    {
        if ($this->heroes->removeElement($hero)) {
            // set the owning side to null (unless already changed)
            if ($hero->getRole() === $this) {
                $hero->setRole(null);
            }
        }

        return $this;
    }

    public function getRoleIcon(): ?RoleIcon
    {
        return $this->roleIcon;
    }

    public function setRoleIcon(?RoleIcon $roleIcon): self
    {
        // unset the owning side of the relation if necessary
        if ($roleIcon === null && $this->roleIcon !== null) {
            $this->roleIcon->setRole(null);
        }

        // set the owning side of the relation if necessary
        if ($roleIcon !== null && $roleIcon->getRole() !== $this) {
            $roleIcon->setRole($this);
        }

        $this->roleIcon = $roleIcon;

        return $this;
    }
}
