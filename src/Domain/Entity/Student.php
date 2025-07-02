<?php

namespace App\Domain\Entity;

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
    #[ORM\Column(nullable: true)]
    private ?float $maxRatePerHour = null;

    #[ORM\OneToOne(inversedBy: 'student', cascade: ['persist', 'remove'])]
    private ?User $related_user = null;

    public function getId(): ?int
    {
        return $this->id;
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
}
