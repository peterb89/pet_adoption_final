<?php

namespace App\Entity\Profile;

use App\Repository\Profile\HousingTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: HousingTypeRepository::class)]
class HousingType
{
    #[ORM\Id] #[ORM\GeneratedValue] #[ORM\Column] private ?int $id = null;
    #[ORM\Column(length: 255)] private ?string $name = null;
    #[ORM\OneToMany(targetEntity: Profile::class, mappedBy: 'housingType')] private Collection $profiles;
    public function __construct()
    {
        $this->profiles = new ArrayCollection();
    }
    public function getId(): ?int
    {
        return $this->id;
    }
    public function getName(): ?string
    {
        return $this->name;
    }
    public function setName(string $n): self
    {
        $this->name = $n;
        return $this;
    }
    public function __toString(): string
    {
        return $this->name ?? '';
    }
}
