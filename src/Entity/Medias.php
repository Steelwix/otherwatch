<?php

namespace App\Entity;

use App\Repository\MediasRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MediasRepository::class)]
class Medias
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'medias')]
    private ?Heroes $heroes = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\OneToMany(mappedBy: 'medias', targetEntity: Illustrations::class, orphanRemoval: true)]
    private Collection $illustrations;

    public function __construct()
    {
        $this->illustrations = new ArrayCollection();
    }

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

    /**
     * @return Collection<int, Illustrations>
     */
    public function getIllustrations(): Collection
    {
        return $this->illustrations;
    }

    public function addIllustration(Illustrations $illustration): self
    {
        if (!$this->illustrations->contains($illustration)) {
            $this->illustrations->add($illustration);
            $illustration->setMedias($this);
        }

        return $this;
    }

    public function removeIllustration(Illustrations $illustration): self
    {
        if ($this->illustrations->removeElement($illustration)) {
            // set the owning side to null (unless already changed)
            if ($illustration->getMedias() === $this) {
                $illustration->setMedias(null);
            }
        }

        return $this;
    }
}
