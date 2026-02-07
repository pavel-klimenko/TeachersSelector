<?php

namespace App\Domain\Entity;

use App\Infrastructure\Repository\TeacherRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TeacherRepository::class)]
#[ORM\Table(name: 'teachers')]
class Teacher
{

    public const LIST_TITLE = 'Our teachers';
    public const SELECT_TEACHERS_PAGE_TITLE = 'Select the teacher';
    public const MIN_RATING = 1;
    public const MAX_RATING = 10;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $rating = null;

    #[ORM\OneToOne(targetEntity: CV::class, mappedBy: 'teacher', cascade: ['persist', 'remove'])]
    private ?CV $cv = null;

    /**
     * @var Collection<int, TeacherHasTeacherExpertises>
     */
    #[ORM\OneToMany(targetEntity: TeacherHasTeacherExpertises::class, mappedBy: 'teacher', cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $teacherHasTeacherExpertises;

    #[ORM\OneToOne(inversedBy: "teacher", cascade: ['persist', 'remove'])]
    private ?User $relatedUser = null;

    #[ORM\ManyToMany(targetEntity: StudyingMode::class, inversedBy: 'teachers')]
    private Collection $studying_modes;

    #[ORM\ManyToMany(targetEntity: PaymentType::class, inversedBy: 'teachers')]
    private Collection $payment_types;

    public function __construct()
    {
        $this->teacherHasTeacherExpertises = new ArrayCollection();
        $this->studying_modes = new ArrayCollection();
        $this->payment_types = new ArrayCollection();
    }

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

    public function getCv(): ?CV
    {
        return $this->cv;
    }

    public function setCv(?CV $cv): static
    {
        $this->cv = $cv;
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
            $relation->setTeacher($this);
        }

        return $this;
    }

    public function removeTeacherHasTeacherExpertise(TeacherHasTeacherExpertises $relation): static
    {
        if ($this->teacherHasTeacherExpertises->removeElement($relation)) {
            if ($relation->getTeacher() === $this) {
                $relation->setTeacher(null);
            }
        }

        return $this;
    }

    /**
     * Удобный геттер, возвращает коллекцию Expertise, извлекая их из association entity.
     *
     * @return Collection<int, Expertise>
     */
    public function getExpertises(): Collection
    {
        $collection = new ArrayCollection();
        foreach ($this->teacherHasTeacherExpertises as $rel) {
            if ($rel->getExpertise() !== null) {
                $collection->add($rel->getExpertise());
            }
        }

        return $collection;
    }

    public function getRelatedUser(): ?User
    {
        return $this->relatedUser;
    }

    public function setRelatedUser(?User $relatedUser): static
    {
        $this->relatedUser = $relatedUser;
        return $this;
    }

    /**
     * @return Collection<int, StudyingMode>
     */
    public function getStudyingModes(): Collection
    {
        return $this->studying_modes;
    }

    public function addStudyingMode(StudyingMode $studyingMode): static
    {
        if (!$this->studying_modes->contains($studyingMode)) {
            $this->studying_modes->add($studyingMode);
        }

        return $this;
    }

    public function removeStudyingMode(StudyingMode $studyingMode): static
    {
        $this->studying_modes->removeElement($studyingMode);
        return $this;
    }

    /**
     * @return Collection<int, PaymentType>
     */
    public function getPaymentTypes(): Collection
    {
        return $this->payment_types;
    }

    public function addPaymentType(PaymentType $paymentType): static
    {
        if (!$this->payment_types->contains($paymentType)) {
            $this->payment_types->add($paymentType);
        }

        return $this;
    }

    public function removePaymentType(PaymentType $paymentType): static
    {
        $this->payment_types->removeElement($paymentType);
        return $this;
    }
}
