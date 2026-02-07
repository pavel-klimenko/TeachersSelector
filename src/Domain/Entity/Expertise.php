<?php

namespace App\Domain\Entity;

use App\Infrastructure\Repository\ExpertiseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ExpertiseRepository::class)]
#[ORM\Table(name: 'expertises')]
class Expertise
{
    public const EXPERTISES_JSON = '/public/json/expertises.json';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $code = null;

    /**
     * @var Collection<int, TeacherHasTeacherExpertises>
     */
    #[ORM\OneToMany(targetEntity: TeacherHasTeacherExpertises::class, mappedBy: 'expertise', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $teacherHasTeacherExpertises;

    public function __construct(string $name = null, string $code = null)
    {
        $this->name = $name;
        $this->code = $code;
        $this->teacherHasTeacherExpertises = new ArrayCollection();
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): static
    {
        $this->code = $code;
        return $this;
    }

    /**
     * @return Collection<int, TeacherHasTeacherExpertises>
     */
    public function getTeacherHasTeacherExpertises(): Collection
    {
        return $this->teacherHasTeacherExpertises;
    }

    public function addTeacherHasTeacherExpertise(TeacherHasTeacherExpertises $relation): static
    {
        if (!$this->teacherHasTeacherExpertises->contains($relation)) {
            $this->teacherHasTeacherExpertises->add($relation);
            $relation->setExpertise($this);
        }

        return $this;
    }

    public function removeTeacherHasTeacherExpertise(TeacherHasTeacherExpertises $relation): static
    {
        if ($this->teacherHasTeacherExpertises->removeElement($relation)) {
            if ($relation->getExpertise() === $this) {
                $relation->setExpertise(null);
            }
        }

        return $this;
    }

    /**
     * Удобный геттер: возвращает коллекцию Teacher, извлекая их из association entity.
     *
     * @return Collection<int, Teacher>
     */
    public function getTeachers(): Collection
    {
        $collection = new ArrayCollection();
        foreach ($this->teacherHasTeacherExpertises as $rel) {
            $teacher = $rel->getTeacher();
            if ($teacher !== null && !$collection->contains($teacher)) {
                $collection->add($teacher);
            }
        }

        return $collection;
    }
}
