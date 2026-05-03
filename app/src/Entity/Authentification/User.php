<?php

namespace App\Entity\Authentification;

use App\Entity\AdoptionApplication;
use App\Entity\Animals\AnimalComment;
use App\Repository\Authentification\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $roles = null;

    #[ORM\Column]
    private ?bool $is_verified = null;

    #[ORM\Column]
    private ?\DateTime $created_at = null;

    #[ORM\Column]
    private ?\DateTime $updated_at = null;

    #[ORM\ManyToMany(targetEntity: AnimalComment::class, mappedBy: 'author')]
    private Collection $animalComments;

    #[ORM\OneToMany(targetEntity: AdoptionApplication::class, mappedBy: 'user')]
    private Collection $adoptionApplications;

    public function __construct()
    {
        $this->animalComments = new ArrayCollection();
        $this->adoptionApplications = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;
        return $this;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;
        return $this;
    }

    public function getRoles(): array
    {
        $roles = json_decode($this->roles ?? '[]', true);

        if (!is_array($roles)) {
            $roles = [];
        }

        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(string|array $roles): static
    {
        $this->roles = is_array($roles) ? json_encode($roles) : $roles;
        return $this;
    }

    public function eraseCredentials(): void
    {
    }

    public function isVerified(): ?bool
    {
        return $this->is_verified;
    }

    public function setIsVerified(bool $is_verified): static
    {
        $this->is_verified = $is_verified;
        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTime $created_at): static
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function getUpdatedAt(): ?\DateTime
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTime $updated_at): static
    {
        $this->updated_at = $updated_at;
        return $this;
    }

    public function getAnimalComments(): Collection
    {
        return $this->animalComments;
    }

    public function addAnimalComment(AnimalComment $animalComment): static
    {
        if (!$this->animalComments->contains($animalComment)) {
            $this->animalComments->add($animalComment);
            $animalComment->addAuthor($this);
        }
        return $this;
    }

    public function removeAnimalComment(AnimalComment $animalComment): static
    {
        if ($this->animalComments->removeElement($animalComment)) {
            $animalComment->removeAuthor($this);
        }
        return $this;
    }

    public function getAdoptionApplications(): Collection
    {
        return $this->adoptionApplications;
    }

    public function addAdoptionApplication(AdoptionApplication $adoptionApplication): static
    {
        if (!$this->adoptionApplications->contains($adoptionApplication)) {
            $this->adoptionApplications->add($adoptionApplication);
            $adoptionApplication->setUser($this);
        }
        return $this;
    }

    public function removeAdoptionApplication(AdoptionApplication $adoptionApplication): static
    {
        if ($this->adoptionApplications->removeElement($adoptionApplication)) {
            if ($adoptionApplication->getUser() === $this) {
                $adoptionApplication->setUser(null);
            }
        }
        return $this;
    }

    public function __toString(): string
    {
        return $this->email ?? 'New User';
    }
}