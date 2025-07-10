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
    public const MIN_RATING = 1;
    public const MAX_RATING = 10;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(nullable: true)]
    private ?int $rating = null;

    #[ORM\OneToMany(targetEntity: TeacherHasTeacherExpertises::class, mappedBy: 'teachers')]
    private $hasTeacherExpertises = null;

    #[ORM\OneToOne(mappedBy: 'teacher', targetEntity: CV::class, cascade: ['persist', 'remove'])]
    private ?CV $cv = null;

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

    /**
     * @var Collection<int, StudyingMode>
     */
    #[ORM\ManyToMany(targetEntity: StudyingMode::class, inversedBy: 'teachers')]
    private Collection $studying_modes;

    /**
     * @var Collection<int, PaymentType>
     */
    #[ORM\ManyToMany(targetEntity: PaymentType::class, inversedBy: 'teachers')]
    private Collection $payment_types;

    public function __construct()
    {
        $this->teacherHasTeacherExpertises = new ArrayCollection();
        $this->expertise = new ArrayCollection();
        $this->studying_modes = new ArrayCollection();
        $this->payment_types = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): static
    {
        $this->id = $id;
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
