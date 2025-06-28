<?php

namespace App\Domain\Entity;

use App\Domain\Enums\Genders;
use App\Infrastructure\Repository\StudentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
#[ORM\Table(name: 'students')]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    #[ORM\Column]
    private ?int $age = null;
    #[ORM\Column(nullable: true, enumType: Genders::class)]
    private ?Genders $gender = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;
    #[ORM\Column(nullable: true)]
    private ?float $maxRatePerHour = null;

    #[ORM\OneToOne(inversedBy: 'student', cascade: ['persist', 'remove'])]
    private ?User $related_user = null;

    #[ORM\ManyToOne(inversedBy: 'students')]
    private ?City $city = null;

    public function getId(): ?int
    {
        return $this->id;
    }
    public function getAge(): ?int
    {
        return $this->age;
    }
    public function setAge(int $age): static
    {
        $this->age = $age;

        return $this;
    }
    public function getGender(): ?Genders
    {
        return $this->gender;
    }
    public function setGender(?Genders $gender): static
    {
        $this->gender = $gender;

        return $this;
    }
    public function getName(): ?string
    {
        return $this->name;
    }
    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }
    public function getMaxRatePerHour(): ?float
    {
        return $this->maxRatePerHour;
    }
    public function setMaxRatePerHour(float $maxRatePerHour): static
    {
        $this->maxRatePerHour = $maxRatePerHour;
        return $this;
    }

    public function getRelatedUser(): ?User
    {
        return $this->related_user;
    }

    public function setRelatedUser(?User $related_user): static
    {
        $this->related_user = $related_user;

        return $this;
    }

    public function getCity(): ?City
    {
        return $this->city;
    }

    public function setCity(?City $city): static
    {
        $this->city = $city;

        return $this;
    }
}
