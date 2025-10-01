<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\StudyingMode;
use App\Domain\Repository\StudyingModeRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<StudyingMode>
 */
class StudyingModeRepository extends ServiceEntityRepository implements StudyingModeRepositoryInterface, ServiceEntityRepositoryInterface
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        ManagerRegistry $registry
    )
    {
        parent::__construct($registry, StudyingMode::class);
    }

    public function getList(): array
    {
        return $this->findAll();
    }

    public function save(StudyingMode $studyingMode): void
    {
        $this->entityManager->persist($studyingMode);
        $this->entityManager->flush();
    }
}
