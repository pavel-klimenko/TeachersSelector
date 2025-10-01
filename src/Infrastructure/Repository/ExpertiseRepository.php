<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Expertise;
use App\Domain\Repository\ExpertiseRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Expertise>
 */
class ExpertiseRepository extends ServiceEntityRepository implements ExpertiseRepositoryInterface, ServiceEntityRepositoryInterface
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        ManagerRegistry $registry
    )
    {
        parent::__construct($registry, Expertise::class);
    }

    public function getList(): array
    {
        return $this->findAll();
    }

    public function save(Expertise $expertise): void
    {
        $this->entityManager->persist($expertise);
        $this->entityManager->flush();
    }

}
