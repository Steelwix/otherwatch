<?php

namespace App\Entity;

use App\Repository\TeamCompsRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeamCompsRepository::class)]
class TeamComps
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'compo')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Heroes $tank = null;

    #[ORM\ManyToOne(inversedBy: 'compo')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Heroes $firstDamage = null;

    #[ORM\ManyToOne(inversedBy: 'compo')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Heroes $secondDamage = null;

    #[ORM\ManyToOne(inversedBy: 'compo')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Heroes $firstSupport = null;

    #[ORM\ManyToOne(inversedBy: 'compo')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Heroes $secondSupport = null;


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

    public function getTank(): ?Heroes
    {
        return $this->tank;
    }

    public function setTank(?Heroes $tank): self
    {
        $this->tank = $tank;

        return $this;
    }

    public function getFirstDamage(): ?Heroes
    {
        return $this->firstDamage;
    }

    public function setFirstDamage(?Heroes $firstDamage): self
    {
        $this->firstDamage = $firstDamage;

        return $this;
    }

    public function getSecondDamage(): ?Heroes
    {
        return $this->secondDamage;
    }

    public function setSecondDamage(?Heroes $secondDamage): self
    {
        $this->secondDamage = $secondDamage;

        return $this;
    }

    public function getFirstSupport(): ?Heroes
    {
        return $this->firstSupport;
    }

    public function setFirstSupport(?Heroes $firstSupport): self
    {
        $this->firstSupport = $firstSupport;

        return $this;
    }

    public function getSecondSupport(): ?Heroes
    {
        return $this->secondSupport;
    }

    public function setSecondSupport(?Heroes $secondSupport): self
    {
        $this->secondSupport = $secondSupport;

        return $this;
    }
}
