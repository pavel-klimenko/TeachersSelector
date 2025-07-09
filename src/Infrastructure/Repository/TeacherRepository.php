<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\PaymentType;
use App\Domain\Entity\Teacher;
use App\Domain\Repository\TeacherRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Teacher>
 */
class TeacherRepository extends ServiceEntityRepository implements TeacherRepositoryInterface, ServiceEntityRepositoryInterface
{
    public function __construct(
        protected EntityManagerInterface $entityManager,
        ManagerRegistry $registry
    )
    {
        parent::__construct($registry, Teacher::class);
    }

    public function save(Teacher $teacher): void
    {
        $this->entityManager->persist($teacher);
        $this->entityManager->flush();
    }

    public function getList(): array
    {
        return $this->findAll();
    }

    public function getTeacher(int $id): object|null
    {
        return $this->findOneBy(['id' => $id]);
    }

    public function findTeachersByFilter(array $arFilter = []): array
    {
        $query = $this->createQueryBuilder('teachers')
            ->join('teachers.cv', 'cv');

            if (!empty($arFilter)) {
                if ($arFilter['rating']) {
                    $query->andWhere('teachers.rating >= :rating')->setParameter('rating', $arFilter['rating']);
                }

                if ($arFilter['maxRate']) {
                    //$query->join('teachers.cv', 'cv')
                        $query->andWhere('cv.rate_per_hour <= :maxRate')
                        ->setParameter('maxRate', $arFilter['maxRate']);
                }

                if ($arFilter['yearsOfExperience']) {
                    //$query->join('teachers.cv', 'cv')
                        $query->andWhere('cv.years_of_experience >= :yearsOfExperience')
                        ->setParameter('yearsOfExperience', $arFilter['yearsOfExperience']);
                }

                if ($arFilter['studyingModeId']) {
                    $query->join('teachers.studying_modes', 'studying_modes')
                        ->andWhere('studying_modes.id = :studyingModeId')
                        ->setParameter('studyingModeId', $arFilter['studyingModeId']);
                }

                if ($arFilter['expertises_ids'] && !empty($arFilter['expertises_ids'])) {
                    $query->join('teachers.teacherHasTeacherExpertises', 'teacherHasTeacherExpertises')
                        ->join('teacherHasTeacherExpertises.expertise', 'expertise')
                        ->andWhere('expertise.id IN (:expertiseIds)')
                        ->setParameter('expertiseIds', $arFilter['expertises_ids']);
                }
            }



        return $query->getQuery()->getResult();
    }
}
