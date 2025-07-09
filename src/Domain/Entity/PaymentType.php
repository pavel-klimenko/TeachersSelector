<?php

namespace App\Domain\Entity;


use App\Infrastructure\Repository\PaymentTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PaymentTypeRepository::class)]
#[ORM\Table(name: 'payment_types')]
class PaymentType
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    /**
     * @var Collection<int, Teacher>
     */
    #[ORM\ManyToMany(targetEntity: Teacher::class, mappedBy: 'payment_types')]
    private Collection $teachers;

    public function __construct()
    {
        $this->teachers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Teacher>
     */
    public function getTeachers(): Collection
    {
        return $this->teachers;
    }

    public function addTeacher(Teacher $teacher): static
    {
        if (!$this->teachers->contains($teacher)) {
            $this->teachers->add($teacher);
            $teacher->addPaymentType($this);
        }

        return $this;
    }

    public function removeTeacher(Teacher $teacher): static
    {
        if ($this->teachers->removeElement($teacher)) {
            $teacher->removePaymentType($this);
        }

        return $this;
    }
}
