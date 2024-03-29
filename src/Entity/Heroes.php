<?php

namespace App\Entity;

use App\Repository\HeroesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\JoinTable;

#[ORM\Entity(repositoryClass: HeroesRepository::class)]
class Heroes
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'heroes')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Roles $role = null;

    #[ORM\OneToMany(mappedBy: 'heroes', targetEntity: Messages::class, orphanRemoval: true)]
    private Collection $messages;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $creationDate = null;

    #[ORM\Column(type: Types::DATE_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $modificationDate = null;

    #[ORM\OneToMany(mappedBy: 'heroes', targetEntity: Medias::class, cascade: ['persist', 'remove'])]
    private Collection $medias;

    #[ORM\OneToOne(mappedBy: 'heroes', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private ?Illustrations $illustrations = null;

    #[ORM\OneToMany(mappedBy: 'heroes', targetEntity: Videos::class)]
    private Collection $videos;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'heroes', targetEntity: Abilities::class)]
    private Collection $abilities;

    #[ORM\Column(length: 2500, nullable: true)]
    private ?string $description = null;

    #[ORM\ManyToMany(targetEntity: self::class)]
    private Collection $counter;

    #[ORM\OneToOne(mappedBy: 'heroe', cascade: ['persist', 'remove'])]
    private ?HeroeBackground $heroeBackground = null;

    #[ORM\ManyToMany(targetEntity: self::class, inversedBy: 'synergy')]
    #[JoinTable(name: "heroes_synergy")]
    private Collection $synergy;

    #[ORM\OneToMany(mappedBy: 'heroe', targetEntity: UpdateTicket::class, orphanRemoval: true)]
    private Collection $ticket;

    #[ORM\OneToMany(mappedBy: 'tank', targetEntity: TeamComps::class)]
    private Collection $compo;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->medias = new ArrayCollection();
        $this->videos = new ArrayCollection();
        $this->abilities = new ArrayCollection();
        $this->counter = new ArrayCollection();
        $this->synergy = new ArrayCollection();
        $this->ticket = new ArrayCollection();
        $this->compo = new ArrayCollection();
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

    public function getRole(): ?Roles
    {
        return $this->role;
    }

    public function setRole(?Roles $role): self
    {
        $this->role = $role;

        return $this;
    }

    /**
     * @return Collection<int, Messages>
     */
    public function getMessages(): Collection
    {
        return $this->messages;
    }

    public function addMessage(Messages $message): self
    {
        if (!$this->messages->contains($message)) {
            $this->messages->add($message);
            $message->setHeroes($this);
        }

        return $this;
    }

    public function removeMessage(Messages $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getHeroes() === $this) {
                $message->setHeroes(null);
            }
        }

        return $this;
    }

    public function getCreationDate(): ?\DateTimeInterface
    {
        return $this->creationDate;
    }

    public function setCreationDate(\DateTimeInterface $creationDate): self
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    public function getModificationDate(): ?\DateTimeInterface
    {
        return $this->modificationDate;
    }

    public function setModificationDate(?\DateTimeInterface $modificationDate): self
    {
        $this->modificationDate = $modificationDate;

        return $this;
    }

    /**
     * @return Collection<int, Medias>
     */
    public function getMedias(): Collection
    {
        return $this->medias;
    }

    public function addMedia(Medias $media): self
    {
        if (!$this->medias->contains($media)) {
            $this->medias->add($media);
            $media->setHeroes($this);
        }

        return $this;
    }

    public function removeMedia(Medias $media): self
    {
        if ($this->medias->removeElement($media)) {
            // set the owning side to null (unless already changed)
            if ($media->getHeroes() === $this) {
                $media->setHeroes(null);
            }
        }

        return $this;
    }

    public function getIllustrations(): ?Illustrations
    {
        return $this->illustrations;
    }

    public function setIllustrations(?Illustrations $illustrations): self
    {
        // unset the owning side of the relation if necessary
        if ($illustrations === null && $this->illustrations !== null) {
            $this->illustrations->setHeroes(null);
        }

        // set the owning side of the relation if necessary
        if ($illustrations !== null && $illustrations->getHeroes() !== $this) {
            $illustrations->setHeroes($this);
        }

        $this->illustrations = $illustrations;

        return $this;
    }

    /**
     * @return Collection<int, Videos>
     */
    public function getVideos(): Collection
    {
        return $this->videos;
    }

    public function addVideo(Videos $video): self
    {
        if (!$this->videos->contains($video)) {
            $this->videos->add($video);
            $video->setHeroes($this);
        }

        return $this;
    }

    public function removeVideo(Videos $video): self
    {
        if ($this->videos->removeElement($video)) {
            // set the owning side to null (unless already changed)
            if ($video->getHeroes() === $this) {
                $video->setHeroes(null);
            }
        }

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * @return Collection<int, Abilities>
     */
    public function getAbilities(): Collection
    {
        return $this->abilities;
    }

    public function addAbility(Abilities $ability): self
    {
        if (!$this->abilities->contains($ability)) {
            $this->abilities->add($ability);
            $ability->setHeroes($this);
        }

        return $this;
    }

    public function removeAbility(Abilities $ability): self
    {
        if ($this->abilities->removeElement($ability)) {
            // set the owning side to null (unless already changed)
            if ($ability->getHeroes() === $this) {
                $ability->setHeroes(null);
            }
        }

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

    /**
     * @return Collection<int, self>
     */
    public function getCounter(): Collection
    {
        return $this->counter;
    }

    public function addCounter(self $counter): self
    {
        if (!$this->counter->contains($counter)) {
            $this->counter->add($counter);
        }

        return $this;
    }

    public function removeCounter(self $counter): self
    {
        $this->counter->removeElement($counter);

        return $this;
    }

    public function getHeroeBackground(): ?HeroeBackground
    {
        return $this->heroeBackground;
    }

    public function setHeroeBackground(?HeroeBackground $heroeBackground): self
    {
        // unset the owning side of the relation if necessary
        if ($heroeBackground === null && $this->heroeBackground !== null) {
            $this->heroeBackground->setHeroe(null);
        }

        // set the owning side of the relation if necessary
        if ($heroeBackground !== null && $heroeBackground->getHeroe() !== $this) {
            $heroeBackground->setHeroe($this);
        }

        $this->heroeBackground = $heroeBackground;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getSynergy(): Collection
    {
        return $this->synergy;
    }

    public function addSynergy(self $synergy): self
    {
        if (!$this->synergy->contains($synergy)) {
            $this->synergy->add($synergy);
        }

        return $this;
    }

    public function removeSynergy(self $synergy): self
    {
        $this->synergy->removeElement($synergy);

        return $this;
    }

    /**
     * @return Collection<int, UpdateTicket>
     */
    public function getTicket(): Collection
    {
        return $this->ticket;
    }

    public function addTicket(UpdateTicket $ticket): self
    {
        if (!$this->ticket->contains($ticket)) {
            $this->ticket->add($ticket);
            $ticket->setHeroe($this);
        }

        return $this;
    }

    public function removeTicket(UpdateTicket $ticket): self
    {
        if ($this->ticket->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getHeroe() === $this) {
                $ticket->setHeroe(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TeamComps>
     */
    public function getCompo(): Collection
    {
        return $this->compo;
    }

    public function addCompo(TeamComps $compo): self
    {
        if (!$this->compo->contains($compo)) {
            $this->compo->add($compo);
            $compo->setTank($this);
        }

        return $this;
    }

    public function removeCompo(TeamComps $compo): self
    {
        if ($this->compo->removeElement($compo)) {
            // set the owning side to null (unless already changed)
            if ($compo->getTank() === $this) {
                $compo->setTank(null);
            }
        }

        return $this;
    }
}
