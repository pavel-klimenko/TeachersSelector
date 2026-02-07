<?php

namespace App\Domain\Entity;

use App\Infrastructure\Repository\TeacherHasTeacherExpertisesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeacherHasTeacherExpertisesRepository::class)]
#[ORM\Table(name: 'teacher_has_teacher_expertises')]
class TeacherHasTeacherExpertises
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $rating = null;

    #[ORM\ManyToOne(targetEntity: Teacher::class, inversedBy: 'teacherHasTeacherExpertises')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Teacher $teacher = null;

    #[ORM\ManyToOne(targetEntity: Expertise::class, inversedBy: 'teacherHasTeacherExpertises')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?Expertise $expertise = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): static
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
