<?php

namespace App\Entity;

use App\Repository\HeroesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

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

    #[ORM\OneToMany(mappedBy: 'heroes', targetEntity: Medias::class)]
    private Collection $medias;

    #[ORM\OneToOne(mappedBy: 'heroes', cascade: ['persist', 'remove'])]
    private ?Illustrations $illustrations = null;

    #[ORM\OneToMany(mappedBy: 'heroes', targetEntity: Videos::class)]
    private Collection $videos;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->medias = new ArrayCollection();
        $this->videos = new ArrayCollection();
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
}
