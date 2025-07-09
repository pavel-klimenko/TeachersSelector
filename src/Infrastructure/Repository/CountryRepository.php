<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Country;
use App\Domain\Repository\CountryRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Country>
 */
class CountryRepository extends ServiceEntityRepository implements CountryRepositoryInterface, ServiceEntityRepositoryInterface
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        ManagerRegistry $registry
    )
    {
        parent::__construct($registry, Country::class);
    }

    public function getList(): array
    {
        return $this->findAll();
    }

    public function save(Country $country): void
    {
        $this->entityManager->persist($country);
        $this->entityManager->flush();
    }
}
