<?php

namespace App\Domain\Entity;

use App\Infrastructure\Repository\TeacherHasTeacherExpertisesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeacherHasTeacherExpertisesRepository::class)]
class TeacherHasTeacherExpertises
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $rating = null;

    #[ORM\ManyToOne(inversedBy: 'expertise')]
    private ?Teacher $teacher = null;

    #[ORM\ManyToOne(inversedBy: 'teacherHasTeacherExpertises')]
    private ?Expertise $expertise = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(int $rating): static
    {
        $this->rating = $rating;
        return $this;
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

    public function getExpertise(): ?Expertise
    {
        return $this->expertise;
    }

    public function setExpertise(?Expertise $expertise): static
    {
        $this->expertise = $expertise;

        return $this;
    }
}
