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

        dd($teacher);

        return $this->render('teachers/detail.html.twig', [
            'title' => 'CV - '.$teacher->getName(),
            'teacher' => $teacher,
        ]);
    }

    #[Route('/teachers', name: 'teachers_get_all')]
    public function getAll(TeacherRepository $teacherRepository)
    {
        $allTeaches = $teacherRepository->findAll();

        dump($allTeaches);

        return $this->render('teachers/list.html.twig', [
            'title' => 'Our teachers',
            'teachers' => $allTeaches,
        ]);
    }
}
