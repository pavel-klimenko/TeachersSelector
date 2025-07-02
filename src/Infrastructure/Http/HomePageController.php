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

final class HomePageController extends AbstractController
{

    public function __construct(
//        private ExpertiseRepository $expertiseRepository,
//        private TeacherRepository $teacherRepository,
//        private UserRepository $userRepository,
//        private StudentRepository $studentRepository,
//        private CountryRepository $countryRepository,
//        private CityRepository $cityRepository,
//        private UserPasswordHasherInterface $userPasswordHasher,
//        private EntityManagerInterface $entityManager
    )
    {}

    #[Route('/', name: 'homepage')]
    public function index(): Response
    {
        //TODO amount of teachers and student on the platform,
        //
        //
        // FOR STUDENT: buttom for selecting the teacher
        // FOR TEACHER: list of all platform`s expertises


        return $this->render('homepage.html.twig', [
            'title' => 'Homepage',
//            'teacher' => $teacher,
//            'expertises' => $arExpertises,
//            'max_teacher_expertise_rating' => 5, //TODO CONST
        ]);
    }

}
