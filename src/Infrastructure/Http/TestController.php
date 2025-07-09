<?php

namespace App\Infrastructure\Http;

use App\Application\PaymentType\DTO\CreatePaymentTypeDTO;
use App\Application\PaymentType\UseCase\CreatePaymentType;
use App\Domain\Entity\Country;
use App\Domain\Entity\PaymentType;
use App\Domain\Entity\Student;
use App\Domain\Entity\TeacherHasTeacherExpertises;
use App\Domain\Entity\User;
use App\Domain\Enums\Genders;
use App\Domain\Enums\UserRoles;
use App\Infrastructure\Repository\CityRepository;
use App\Domain\Services\HelperServiceInterface;
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
use App\Application\PaymentType\UseCase\GetDemoList;

final class TestController extends AbstractController
{

    public function __construct(
        private StudyingModelsRepository    $studyingModelsRepository,
        private ExpertiseRepository         $expertiseRepository,
        private TeacherRepository           $teacherRepository,
        private UserRepository              $userRepository,
        private StudentRepository           $studentRepository,
        private CountryRepository           $countryRepository,
        private CityRepository              $cityRepository,
        private UserPasswordHasherInterface $userPasswordHasher,
        private EntityManagerInterface      $entityManager,
        private HelperServiceInterface      $helperService,
        private CreatePaymentType           $CreatePaymentTypeCase,
        private GetDemoList           $GetDemoList,

    )
    {}

    #[Route('/test', name: 'test')]
    public function index(): Response
    {

        //TODO работает
//        $arPaymentTypes = $this->GetDemoList->execute();
//        if (!empty($arPaymentTypes)) {
//            foreach ($arPaymentTypes as $type) {
//                $CreatePaymentTypeDTO = new CreatePaymentTypeDTO($type['name'], $type['code']);
//                $this->CreatePaymentTypeCase->execute($CreatePaymentTypeDTO);
//            }
//        }

        exit();
    }

}
