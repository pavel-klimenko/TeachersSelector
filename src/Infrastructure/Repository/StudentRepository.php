<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Student;
use App\Domain\Repository\StudentRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Student>
 */
class StudentRepository extends ServiceEntityRepository implements StudentRepositoryInterface, ServiceEntityRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Student::class);
    }

    public function getAmount():int
    {
        return $this->count();
    }

    public function getList(): array
    {
        return $this->findAll();
    }

    public function getStudent(int $id): object|null
    {
        return $this->findOneBy(['id' => $id]);
    }

}
