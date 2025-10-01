<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\TeacherHasTeacherExpertises;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<TeacherHasTeacherExpertises>
 */
class TeacherHasTeacherExpertisesRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, TeacherHasTeacherExpertises::class);
    }
}
