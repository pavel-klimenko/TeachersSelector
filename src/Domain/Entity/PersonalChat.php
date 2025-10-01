<?php

namespace App\Domain\Entity;

use App\Infrastructure\Repository\PersonalChatRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PersonalChatRepository::class)]
class PersonalChat
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'personalChats')]
    private ?Student $student = null;

    #[ORM\ManyToOne(inversedBy: 'personalChats')]
    private ?Teacher $teacher = null;

    /**
     * @var Collection<int, PersonalChatMessages>
     */
    #[ORM\ManyToMany(targetEntity: PersonalChatMessages::class, mappedBy: 'PersonalChat')]
    private Collection $related_user;

    public function __construct()
    {
        $this->related_user = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStudent(): ?Student
    {
        return $this->student;
    }

    public function setStudent(?Student $student): static
    {
        $this->student = $student;

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

    /**
     * @return Collection<int, PersonalChatMessages>
     */
    public function getRelatedUser(): Collection
    {
        return $this->related_user;
    }

    public function addRelatedUser(PersonalChatMessages $relatedUser): static
    {
        if (!$this->related_user->contains($relatedUser)) {
            $this->related_user->add($relatedUser);
            $relatedUser->addPersonalChat($this);
        }

        return $this;
    }

    public function removeRelatedUser(PersonalChatMessages $relatedUser): static
    {
        if ($this->related_user->removeElement($relatedUser)) {
            $relatedUser->removePersonalChat($this);
        }

        return $this;
    }
}
