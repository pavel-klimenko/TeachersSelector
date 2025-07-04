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

        $maxRate = 12;
        $yearsOfExperience = 6;
        //years_of_experience

        //TODO добавить строгое соответствие списку из фильтра
        $arStudyingModelsIds = [1, 2];
        $arPaymentTypesIds = [3];
        $arExpertisesIds = [6];

        return $this->createQueryBuilder('teachers')
//            ->where('teachers.rating > :rating')
//            ->setParameter('rating', 1)

//            ->join('teachers.cv', 'cv')
//            ->where('cv.rate_per_hour <= :maxRate')
//            ->setParameter('maxRate', $maxRate)

//            ->where('cv.years_of_experience >= :yearsOfExperience')
//            ->setParameter('yearsOfExperience', $yearsOfExperience)

//            ->join('teachers.studying_modes', 'studying_modes')
//            ->where('studying_modes.id IN (:ids)')
//            ->setParameter('ids', $arStudyingModelsIds)

//            ->join('teachers.payment_types', 'payment_types')
//            ->where('payment_types.id IN (:payment_types_ids)')
//            ->setParameter('payment_types_ids', $arPaymentTypesIds)

                //TODO не правильно работает
            ->join('teachers.teacherHasTeacherExpertises', 'teacherHasTeacherExpertises')
            ->where('teacherHasTeacherExpertises.id IN (:expertises_ids)')
            ->setParameter('expertises_ids', $arExpertisesIds)

            ->getQuery()
            ->getResult();
    }
}
