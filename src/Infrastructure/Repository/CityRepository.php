<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\City;
use App\Domain\Repository\CityRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<City>
 */
class CityRepository extends ServiceEntityRepository implements CityRepositoryInterface, ServiceEntityRepositoryInterface
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        ManagerRegistry $registry
    )
    {
        parent::__construct($registry, City::class);
    }

    public function save(City $city): void
    {
        $this->entityManager->persist($city);
        $this->entityManager->flush();
    }

    public function getAmount():int
    {
        return $this->count();
    }
}
