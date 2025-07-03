<?php

namespace App\Infrastructure\Http;

use App\Domain\Entity\Country;
use App\Domain\Entity\Student;
use App\Domain\Entity\TeacherHasTeacherExpertises;
use App\Domain\Entity\User;
use App\Domain\Enums\Genders;
use App\Domain\Enums\UserRoles;
use App\Infrastructure\Repository\CityRepository;
use App\Domain\Services\HelperService;
use App\Infrastructure\Repository\CountryRepository;
use App\Infrastructure\Repository\ExpertiseRepository;
use App\Infrastructure\Repository\StudentRepository;
use App\Infrastructure\Repository\StudyingModelsRepository;
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
        private StudyingModelsRepository $studyingModelsRepository,
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




        exit();
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

        $arStudyingModels = $this->studyingModelsRepository->findAll();




        $arTeachers = $this->teacherRepository->findAll();
        foreach ($arTeachers as $teacher) {
            foreach ($arStudyingModels as $mode) {
                $teacher->addStudyingMode($mode);
                $this->entityManager->persist($teacher);
                $this->entityManager->flush();
            }

        }

        exit();






//        $randomteacher = $this->expertiseRepository->findBy(['code' => 'math']);
//        $mathExpertise = reset($mathExpertise);




        dd(1212);
    }

}
