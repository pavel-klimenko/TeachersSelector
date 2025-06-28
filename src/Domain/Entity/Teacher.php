<?php

namespace App\Domain\Entity;

use App\Domain\Enums\Genders;
use App\Infrastructure\Repository\TeacherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeacherRepository::class)]
#[ORM\Table(name: 'teachers')]
class Teacher
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $age = null;

    #[ORM\Column(nullable: true, enumType: Genders::class)]
    private ?Genders $gender = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(nullable: true)]
    private ?int $rating = null;

    #[ORM\Column(nullable: true)]
    private ?int $years_experience = null;

    #[ORM\OneToMany(targetEntity: TeacherHasTeacherExpertises::class, mappedBy: 'teachers')]
    private $hasTeacherExpertises = null;

    #[ORM\ManyToOne(inversedBy: 'teachers')]
    private ?City $city = null;


    /**
     * @var Collection<int, TeacherHasTeacherExpertises>
     */
    #[ORM\OneToMany(targetEntity: TeacherHasTeacherExpertises::class, mappedBy: 'teacher')]
    private Collection $teacherHasTeacherExpertises;

    /**
     * @var Collection<int, TeacherHasTeacherExpertises>
     */
    #[ORM\OneToMany(targetEntity: TeacherHasTeacherExpertises::class, mappedBy: 'teacher')]
    private Collection $expertise;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?User $related_user = null;

    public function __construct()
    {
        $this->teacherHasTeacherExpertises = new ArrayCollection();
        $this->expertise = new ArrayCollection();
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

    public function getRating(): ?int
    {
        return $this->rating;
    }

    public function setRating(?int $rating): static
    {
        $this->rating = $rating;

        return $this;
    }

    public function getYearsExperience(): ?int
    {
        return $this->years_experience;
    }

    public function setYearsExperience(?int $years_experience): static
    {
        $this->years_experience = $years_experience;
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
            $teacherHasTeacherExpertise->setTeacher($this);
        }

        return $this;
    }

    public function removeTeacherHasTeacherExpertise(TeacherHasTeacherExpertises $teacherHasTeacherExpertise): static
    {
        if ($this->teacherHasTeacherExpertises->removeElement($teacherHasTeacherExpertise)) {
            // set the owning side to null (unless already changed)
            if ($teacherHasTeacherExpertise->getTeacher() === $this) {
                $teacherHasTeacherExpertise->setTeacher(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, TeacherHasTeacherExpertises>
     */
    public function getExpertise(): Collection
    {
        return $this->expertise;
    }

    public function addExpertise(TeacherHasTeacherExpertises $expertise): static
    {
        if (!$this->expertise->contains($expertise)) {
            $this->expertise->add($expertise);
            $expertise->setTeacher($this);
        }

        return $this;
    }

    public function removeExpertise(TeacherHasTeacherExpertises $expertise): static
    {
        if ($this->expertise->removeElement($expertise)) {
            // set the owning side to null (unless already changed)
            if ($expertise->getTeacher() === $this) {
                $expertise->setTeacher(null);
            }
        }

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
