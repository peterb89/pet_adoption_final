<?php

namespace App\Entity\Animals;

use App\Entity\Animal\AnimalComment;
use App\Repository\AnimalRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AnimalRepository::class)]
class Animal
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $name = null;

    #[ORM\Column(length: 100, nullable: true)]
    private ?string $breed = null;

    #[ORM\Column(nullable: true)]
    private ?int $age = null;

    #[ORM\Column(length: 150, nullable: true)]
    private ?string $location = null;

    #[ORM\Column(length: 50)]
    private ?string $status = 'available';

    #[ORM\ManyToOne]
    private ?Species $species = null;

    /**
     * @var Collection<int, AnimalComment>
     */
    #[ORM\OneToMany(targetEntity: AnimalComment::class, mappedBy: 'animal')]
    private Collection $animalComments;

    public function __construct()
    {
        $this->animalComments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getBreed(): ?string
    {
        return $this->breed;
    }

    public function setBreed(?string $breed): static
    {
        $this->breed = $breed;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): static
    {
        $this->location = $location;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getSpecies(): ?Species
    {
        return $this->species;
    }

    public function setSpecies(?Species $species): static
    {
        $this->species = $species;

        return $this;
    }

    /**
     * @return Collection<int, AnimalComment>
     */
    public function getAnimalComments(): Collection
    {
        return $this->animalComments;
    }

    public function addAnimalComment(AnimalComment $animalComment): static
    {
        if (!$this->animalComments->contains($animalComment)) {
            $this->animalComments->add($animalComment);
            $animalComment->setAnimal($this);
        }

        return $this;
    }

    public function removeAnimalComment(AnimalComment $animalComment): static
    {
        if ($this->animalComments->removeElement($animalComment)) {
            // set the owning side to null (unless already changed)
            if ($animalComment->getAnimal() === $this) {
                $animalComment->setAnimal(null);
            }
        }

        return $this;
    }
}
