<?php

namespace App\Domain\Entity;

use App\Infrastructure\Repository\CVRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CVRepository::class)]
class CV
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'cv', targetEntity: Teacher::class)]
    #[ORM\JoinColumn(name: 'teacher_id', referencedColumnName: 'id')]
    private ?Teacher $teacher = null;

    #[ORM\Column]
    private ?float $rate_per_hour = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $personal_characteristics = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $experience = null;

    #[ORM\Column]
    private ?float $years_of_experience = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeacher(): ?Teacher
    {
        return $this->teacher;
    }

    public function setTeacher(?Teacher $teacher): static
    {
        $this->teacher = $teacher;

        return $this;
    }

    public function getRatePerHour(): ?float
    {
        return $this->rate_per_hour;
    }

    public function setRatePerHour(float $rate_per_hour): static
    {
        $this->rate_per_hour = $rate_per_hour;

        return $this;
    }

    public function getPersonalCharacteristics(): ?string
    {
        return $this->personal_characteristics;
    }

    public function setPersonalCharacteristics(string $personal_characteristics): static
    {
        $this->personal_characteristics = $personal_characteristics;

        return $this;
    }

    public function getExperience(): ?string
    {
        return $this->experience;
    }

    public function setExperience(string $experience): static
    {
        $this->experience = $experience;

        return $this;
    }

    public function getYearsOfExperience(): ?float
    {
        return $this->years_of_experience;
    }

    public function setYearsOfExperience(float $years_of_experience): static
    {
        $this->years_of_experience = $years_of_experience;

        return $this;
    }
}
