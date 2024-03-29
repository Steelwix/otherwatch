<?php

namespace App\Entity;

use App\Repository\UsersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UsersRepository::class)]
class Users implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = ["ROLE_USER"];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    #[ORM\OneToOne(mappedBy: 'users', cascade: ['persist', 'remove'])]
    private ?ProfilesPictures $profilesPictures = null;

    #[ORM\OneToMany(mappedBy: 'users', targetEntity: Messages::class, orphanRemoval: true)]
    private Collection $messages;

    #[ORM\OneToMany(mappedBy: 'author', targetEntity: UpdateTicket::class)]
    private Collection $ticket;

    #[ORM\Column]
    private ?bool $isVerified = false;

    public function __construct()
    {
        $this->messages = new ArrayCollection();
        $this->ticket = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getProfilesPictures(): ?ProfilesPictures
    {
        return $this->profilesPictures;
    }

    public function setProfilesPictures(?ProfilesPictures $profilesPictures): self
    {
        // unset the owning side of the relation if necessary
        if ($profilesPictures === null && $this->profilesPictures !== null) {
            $this->profilesPictures->setUsers(null);
        }

        // set the owning side of the relation if necessary
        if ($profilesPictures !== null && $profilesPictures->getUsers() !== $this) {
            $profilesPictures->setUsers($this);
        }

        $this->profilesPictures = $profilesPictures;

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
            $message->setUsers($this);
        }

        return $this;
    }

    public function removeMessage(Messages $message): self
    {
        if ($this->messages->removeElement($message)) {
            // set the owning side to null (unless already changed)
            if ($message->getUsers() === $this) {
                $message->setUsers(null);
            }
        }

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
            $ticket->setAuthor($this);
        }

        return $this;
    }

    public function removeTicket(UpdateTicket $ticket): self
    {
        if ($this->ticket->removeElement($ticket)) {
            // set the owning side to null (unless already changed)
            if ($ticket->getAuthor() === $this) {
                $ticket->setAuthor(null);
            }
        }

        return $this;
    }

    public function isIsVerified(): ?bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): self
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
