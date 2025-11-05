<?php

namespace App\Domain\Entity;

use App\Infrastructure\Repository\StudentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StudentRepository::class)]
#[ORM\Table(name: 'students')]
class Student
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToOne(inversedBy: 'student', cascade: ['persist', 'remove'])]
    private ?User $related_user = null;

    /**
     * @var Collection<int, PersonalChat>
     */
    #[ORM\OneToMany(targetEntity: PersonalChat::class, mappedBy: 'student')]
    private Collection $personalChats;

    public function __construct()
    {
        $this->personalChats = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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
     * @return Collection<int, PersonalChat>
     */
    public function getPersonalChats(): Collection
    {
        return $this->personalChats;
    }
}
