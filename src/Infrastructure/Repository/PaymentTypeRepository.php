<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\PaymentType;
use App\Domain\Repository\PaymentTypeRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @extends ServiceEntityRepository<PaymentType>
 */
class PaymentTypeRepository extends ServiceEntityRepository implements PaymentTypeRepositoryInterface, ServiceEntityRepositoryInterface
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        ManagerRegistry $registry
    )
    {
        parent::__construct($registry, PaymentType::class);
    }

    public function getList(): array
    {
        return $this->findAll();
    }

    public function save(PaymentType $paymentType): void
    {
        $this->entityManager->persist($paymentType);
        $this->entityManager->flush();
    }


//    /**
//     * @return PaymentTypes[] Returns an array of PaymentTypes objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('p.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?PaymentTypes
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
