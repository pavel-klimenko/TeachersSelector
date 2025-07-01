<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Expertise;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Expertise>
 */
class ExpertiseRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Expertise::class);
    }

    public function getAllIds(): array
    {
        $arAllExpertises = $this->createQueryBuilder('e')
            ->select('e.id')
            ->getQuery()
            ->getResult();

        $arIds = [];
        foreach ($arAllExpertises as $expertise) {
            $arIds[] = $expertise['id'];
        }

        return $arIds;
    }

    //    /**
    //     * @return Expertise[] Returns an array of Expertise objects
    //     */
    //    public function findByExampleField($value): array
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->orderBy('e.id', 'ASC')
    //            ->setMaxResults(10)
    //            ->getQuery()
    //            ->getResult()
    //        ;
    //    }

    //    public function findOneBySomeField($value): ?Expertise
    //    {
    //        return $this->createQueryBuilder('e')
    //            ->andWhere('e.exampleField = :val')
    //            ->setParameter('val', $value)
    //            ->getQuery()
    //            ->getOneOrNullResult()
    //        ;
    //    }
}
