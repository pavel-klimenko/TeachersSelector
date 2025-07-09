<?php

namespace App\Domain\Entity;

use App\Infrastructure\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CountryRepository::class)]
#[ORM\Table(name: 'countries')]
class Country
{
    public const COUNTRIES_JSON = '/public/json/countries_iso_codes.json';

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    /**
     * @var \Doctrine\Common\Collections\Collection<int, Student>
     */
    #[ORM\OneToMany(targetEntity: Student::class, mappedBy: 'country')]
    private \Doctrine\Common\Collections\Collection $students;

    /**
     * @var Collection<int, Teacher>
     */
    #[ORM\OneToMany(targetEntity: Teacher::class, mappedBy: 'country')]
    private Collection $teachers;

    #[ORM\Column(length: 255)]
    private ?string $iso_code = null;

    public function __construct()
    {
        $this->students = new ArrayCollection();
        $this->teachers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    /**
     * @return \Doctrine\Common\Collections\Collection<int, Student>
     */
    public function getStudents(): \Doctrine\Common\Collections\Collection
    {
        return $this->students;
    }

    /**
     * @return Collection<int, Teacher>
     */
    public function getTeachers(): Collection
    {
        return $this->teachers;
    }

    public function getIsoCode(): ?string
    {
        return $this->iso_code;
    }

    public function setIsoCode(string $iso_code): static
    {
        $this->iso_code = $iso_code;

        return $this;
    }
}
