<?php

namespace App\Domain\Entity;

use App\Domain\Repository\ExpertiseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExpertiseRepository::class)]
class Expertise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\OneToMany(targetEntity: TeacherHasTeacherExpertises::class, mappedBy: 'expertises')]
    private $hasTeachers = null;

    /**
     * @var Collection<int, TeacherHasTeacherExpertises>
     */
    #[ORM\OneToMany(targetEntity: TeacherHasTeacherExpertises::class, mappedBy: 'expertise')]
    private Collection $teacherHasTeacherExpertises;

    public function __construct()
    {
        $this->teacherHasTeacherExpertises = new ArrayCollection();
    }


//    /**
//     * @var Collection<int, TeacherHasTeacherExpertises>
//     */

//    #[ORM\OneToMany(targetEntity: TeacherHasTeacherExpertises::class, mappedBy: 'expertise')]
//    private Collection $teacher;
//
//    public function __construct()
//    {
//        $this->teacher = new ArrayCollection();
//    }

//    #[ORM\ManyToMany(targetEntity: Teacher::class, mappedBy: 'teachers')]
//    private Collection $teachers;
//
//    public function __construct()
//    {
//        $this->teachers = new ArrayCollection();
//    }


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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;
        return $this;
    }

//    public function getTeachers(): Collection
//    {
//        return $this->teachers;
//    }

//    public function addTeacher(Teacher $teacher): self
//    {
//        if (!$this->teachers->contains($teacher)) {
//            $this->teachers[] = $teacher;
//        }
//
//        return $this;
//    }
//
//    public function removeTeacher(Teacher $teacher): self
//    {
//        $this->teachers->removeElement($teacher);
//        return $this;
//    }

//    /**
//     * @return Collection<int, TeacherHasTeacherExpertises>
//     */
//    public function getTeacher(): Collection
//    {
//        return $this->teacher;
//    }
//
//    public function addTeacher(TeacherHasTeacherExpertises $teacher): static
//    {
//        if (!$this->teacher->contains($teacher)) {
//            $this->teacher->add($teacher);
//            $teacher->setExpertise($this);
//        }
//
//        return $this;
//    }
//
//    public function removeTeacher(TeacherHasTeacherExpertises $teacher): static
//    {
//        if ($this->teacher->removeElement($teacher)) {
//            // set the owning side to null (unless already changed)
//            if ($teacher->getExpertise() === $this) {
//                $teacher->setExpertise(null);
//            }
//        }
//
//        return $this;
//    }

/**
 * @return Collection<int, TeacherHasTeacherExpertises>
 */
public function getTeacherHasTeacherExpertises(): Collection
{
    return $this->teacherHasTeacherExpertises;
}

public function addTeacherHasTeacherExpertise(TeacherHasTeacherExpertises $teacherHasTeacherExpertise): static
{
    if (!$this->teacherHasTeacherExpertises->contains($teacherHasTeacherExpertise)) {
        $this->teacherHasTeacherExpertises->add($teacherHasTeacherExpertise);
        $teacherHasTeacherExpertise->setExpertise($this);
    }

    return $this;
}

public function removeTeacherHasTeacherExpertise(TeacherHasTeacherExpertises $teacherHasTeacherExpertise): static
{
    if ($this->teacherHasTeacherExpertises->removeElement($teacherHasTeacherExpertise)) {
        // set the owning side to null (unless already changed)
        if ($teacherHasTeacherExpertise->getExpertise() === $this) {
            $teacherHasTeacherExpertise->setExpertise(null);
        }
    }

    return $this;
}
}
