<?php

declare(strict_types=1);

namespace App\Infrastructure\Http\Teacher\Controller;

//use App\Application\Teacher\CreateTeacherUseCase;

use App\Domain\Entity\Teacher;
use App\Domain\Enums\Genders;
use App\Infrastructure\Repository\TeacherRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class TeacherController extends AbstractController
{
//    public function __construct(
//        private CreateTeacherUseCase $createTeacherUseCase
//    ){}


//    #[Route('/teacher-create', name: 'teacher_create')]
//    public function create(EntityManagerInterface $em)
//    {
//        //TODO validate POST params
//        //TODO move to services and repos
//        $teacher = (new Teacher())
//            ->setName('Oleg1')
//            ->setAge(35)
//            ->setGender(Genders::MALE)
//            ->setRating(10)
//            ->setYearsExperience(5);
//
//        $em->persist($teacher);
//        $em->flush();
//
//        exit();
//    }
//    public function update(TeacherRepository $teacherRepository, EntityManagerInterface $em, int $id)
//    {
//        $teacher = $teacherRepository->findOneBy(['id' => $id]);
//
//        if (!$teacher) {
//            throw new \RuntimeException("Teacher with id = $id not found");
//        }
//
//        $name = 'Ivan';
//        $age = 55;
//        $gender = Genders::FEMALE;
//        $rating = 10;
//
//        $teacher->setName($name)
//            ->setAge($age)
//            ->setGender($gender)
//            ->setRating($rating);
//
//        $em->flush();
//
//        exit();
//    }
//    public function delete(TeacherRepository $teacherRepository, EntityManagerInterface $em, int $id)
//    {
//        $teacher = $teacherRepository->findOneBy(['id' => $id]);
//        if (!$teacher) {
//            throw new \RuntimeException("Teacher with id = $id not found");
//        }
//
//        $em->remove($teacher);
//        $em->flush();
//
//        exit();
//    }

    public function getById(TeacherRepository $teacherRepository, int $id)
    {
        $teacher = $teacherRepository->findOneBy(['id' => $id]);

        $arExpertises = [];
        foreach ($teacher->getTeacherHasTeacherExpertises() as $expertise) {
            $arExpertises[$expertise->getExpertise()->getName()] = $expertise->getRating();
        }

        $arStudyingModes = [];
        foreach ($teacher->getStudyingModes() as $mode) {
            $arStudyingModes[] = $mode->getName();
        }

        $arPaymentTypes = [];
        foreach ($teacher->getPaymentTypes() as $type) {
            $arPaymentTypes[] = $type->getName();
        }

        return $this->render('teachers/detail.html.twig', [
            'title' => 'CV - '.$teacher->getRelatedUser()->getName(),
            'teacher' => $teacher,
            'expertises' => $arExpertises,
            'studying_modes' => $arStudyingModes,
            'payment_types' => $arPaymentTypes,
            'max_teacher_expertise_rating' => 5, //TODO CONST
        ]);
    }

    #[Route('/teachers', name: 'teachers_get_all')]
    public function getAll(TeacherRepository $teacherRepository)
    {
        $allTeaches = $teacherRepository->findAll();
        return $this->render('teachers/list.html.twig', [
            'title' => 'Our teachers',
            'teachers' => $allTeaches,
            'max_teacher_common_rating' => 10 //TODO const
        ]);
    }

    #[Route('/teachers_get_by_filter', name: 'teachers_get_by_filter')]
    public function getByFilter(TeacherRepository $teacherRepository)
    {
        $arTeaches = $teacherRepository->findTeachersByFilter(['rating']);
        dd($arTeaches);
//        $allTeaches = $teacherRepository->findAll();
//        return $this->render('teachers/list.html.twig', [
//            'title' => 'Our teachers',
//            'teachers' => $allTeaches,
//            'max_teacher_common_rating' => 10 //TODO const
//        ]);
    }
}
