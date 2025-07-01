<?php

namespace App\Infrastructure\Http;

use App\Domain\Entity\Country;
use App\Domain\Entity\Student;
use App\Domain\Entity\TeacherHasTeacherExpertises;
use App\Domain\Entity\User;
use App\Domain\Enums\Genders;
use App\Infrastructure\Repository\CityRepository;
use App\Domain\Services\HelperService;
use App\Infrastructure\Repository\CountryRepository;
use App\Infrastructure\Repository\ExpertiseRepository;
use App\Infrastructure\Repository\StudentRepository;
use App\Infrastructure\Repository\TeacherRepository;
use App\Infrastructure\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

final class TestController extends AbstractController
{

    public function __construct(
        private ExpertiseRepository $expertiseRepository,
        private TeacherRepository $teacherRepository,
        private UserRepository $userRepository,
        private StudentRepository $studentRepository,
        private CountryRepository $countryRepository,
        private CityRepository $cityRepository,
        private UserPasswordHasherInterface $userPasswordHasher,
        private EntityManagerInterface $entityManager
    )
    {}

    #[Route('/test', name: 'test')]
    public function index(): Response
    {

        //Getting up to four random teacher`s expertises
        $arAllExpertisesIds = $this->expertiseRepository->findAll();
        if (!empty($arAllExpertisesIds)) {
            $min = 0;
            $max = count($arAllExpertisesIds) - 1;

            $arRandomExpertises = [];
            for ($i = 0; $i < 4; $i++) {
                $arRandomExpertises[] = $arAllExpertisesIds[rand($min, $max)];
            }
        }

        $arTeachers = $this->teacherRepository->findAll();
        foreach ($arTeachers as $teacher) {
            $arAttachedExpertises = [];
            foreach ($arRandomExpertises as $expertise) {

                $expertiseId = $expertise->getId();
                if (!in_array($expertiseId, $arAttachedExpertises)) {

                    $teacherHasTeacherExpertises = new TeacherHasTeacherExpertises();
                    $teacherHasTeacherExpertises
                        ->setExpertise($expertise)
                        ->setTeacher($teacher)
                        ->setRating(5);

                    $this->entityManager->persist($teacherHasTeacherExpertises);
                    $this->entityManager->flush();

                    $arAttachedExpertises[] = $expertiseId;
                }
            }
        }

        exit();






//        $randomteacher = $this->expertiseRepository->findBy(['code' => 'math']);
//        $mathExpertise = reset($mathExpertise);




        dd(1212);
    }

}
