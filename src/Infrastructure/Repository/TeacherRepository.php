<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Teacher;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Teacher>
 */
class TeacherRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Teacher::class);
    }

    public function findTeachersByFilter(array $arFilter): array
    {

        $rating = 1;
        $maxRate = 12;
        $yearsOfExperience = 6;

        //TODO добавить строгое соответствие списку из фильтра
        $arStudyingModesIds = [1, 2];
        $arPaymentTypesIds = [1,2];
        $arExpertisesIds = [6];

        //TODO упростить и оптимизировать!

        return $this->createQueryBuilder('teachers')
            ->where('teachers.rating > :rating')
            ->setParameter('rating', $rating)

            ->join('teachers.cv', 'cv')
            ->where('cv.rate_per_hour <= :maxRate')
            ->setParameter('maxRate', $maxRate)

            ->where('cv.years_of_experience >= :yearsOfExperience')
            ->setParameter('yearsOfExperience', $yearsOfExperience)


             //filtering by studying_modes ids
            ->join('teachers.studying_modes', 'studying_modes')
            ->where('studying_modes.id IN (:ids)')
            ->groupBy('teachers.id')
            ->having('COUNT(DISTINCT studying_modes.id) = :count')
            ->setParameter('ids', $arStudyingModesIds)
            ->setParameter('count', count($arStudyingModesIds))

             //filtering by payment_types ids
            ->join('teachers.payment_types', 'payment_types')
            ->where('payment_types.id IN (:ids)')
            ->groupBy('teachers.id')
            ->having('COUNT(DISTINCT payment_types.id) = :count')
            ->setParameter('ids', $arPaymentTypesIds)
            ->setParameter('count', count($arPaymentTypesIds))

                //TODO не правильно работает
//            ->join('teachers.teacherHasTeacherExpertises', 'teacherHasTeacherExpertises')
//            ->where('teacherHasTeacherExpertises.id IN (:expertises_ids)')
//            ->setParameter('expertises_ids', $arExpertisesIds)

            ->getQuery()
            ->getResult();
    }
}
