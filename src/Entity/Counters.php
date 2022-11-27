<?php

namespace App\Entity;

use App\Repository\CountersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountersRepository::class)]
class Counters
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'isCountered')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Heroes $isCountered = null;

    #[ORM\ManyToOne(inversedBy: 'counter')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Heroes $counter = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIsCountered(): ?Heroes
    {
        return $this->isCountered;
    }

    public function setIsCountered(?Heroes $isCountered): self
    {
        $this->isCountered = $isCountered;

        return $this;
    }

    public function getCounter(): ?Heroes
    {
        return $this->counter;
    }

    public function setCounter(?Heroes $counter): self
    {
        $this->counter = $counter;

        return $this;
    }
}
