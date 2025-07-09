<?php

namespace App\Infrastructure\Http;

use App\Application\City\DTO\CreateCityDTO;
use App\Application\City\UseCase\CreateCity;
use App\Application\City\UseCase\GetDemoCitiesList;
use App\Application\Country\DTO\CreateCountryDTO;
use App\Application\Country\Factory\CountryFactory;
use App\Application\Country\UseCase\CreateCountry;
use App\Application\Country\UseCase\GetAllCountries;
use App\Application\Country\UseCase\GetDemoCountriesList;
use App\Application\Expertise\DTO\CreateExpertiseDTO;
use App\Application\Expertise\UseCase\GetRandomDemoExpertises;
use App\Application\PaymentType\DTO\CreatePaymentTypeDTO;
use App\Application\PaymentType\UseCase\CreatePaymentType;
use App\Application\PaymentType\UseCase\GetAllPaymentTypes;
use App\Application\PaymentType\UseCase\GetDemoPaymentTypesList;
use App\Application\StudyingMode\DTO\CreateStudyingModeDTO;
use App\Application\StudyingMode\UseCase\CreateStudyingMode;
use App\Application\StudyingMode\UseCase\GetAllStudyingModes;
use App\Application\StudyingMode\UseCase\GetDemoStudyingModesList;
use App\Application\Teacher\UseCase\AddPaymentTypeToTeacher;
use App\Application\Teacher\UseCase\AddStudyingModeToTeacher;
use App\Application\Teacher\UseCase\GetAllTeachers;
use App\Application\User\DTO\CreateUserDTO;
use App\Application\User\UseCase\CreateUser;
use App\Application\User\UseCase\CurrentUserRoles;
use App\Application\User\UseCase\GetAllUsers;
use App\Application\User\UseCase\GetUserRoles;
use App\Domain\Entity\City;
use App\Domain\Entity\Country;
use App\Domain\Entity\PaymentType;
use App\Domain\Entity\Student;
use App\Domain\Entity\StudyingMode;
use App\Domain\Entity\TeacherHasTeacherExpertises;
use App\Domain\Entity\User;
use App\Domain\Enums\Genders;
use App\Domain\Enums\UserRoles;
use App\Domain\Factory\CVFactory;
use App\Domain\Factory\StudentFactory;
use App\Domain\Factory\TeacherFactory;
use App\Domain\Factory\TeacherHasTeacherExpertisesFactory;
use App\Domain\Factory\UserFactory;
use App\Infrastructure\Repository\CityRepository;
use App\Domain\Services\HelperServiceInterface;
use App\Infrastructure\Repository\CountryRepository;
use App\Infrastructure\Repository\ExpertiseRepository;
use App\Infrastructure\Repository\StudentRepository;
use App\Infrastructure\Repository\StudyingModeRepository;
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
use App\Application\PaymentType\UseCase\GetDemoPaymentTypesList as GetDemoListPT;
use App\Application\StudyingMode\UseCase\GetDemoStudyingModesList as GetDemoListSM;
use App\Application\Expertise\UseCase\GetDemoExpertisesList;
use App\Application\Expertise\UseCase\CreateExpertise;

final class TestController extends AbstractController
{

    public function __construct(
        private StudyingModeRepository    $studyingModelsRepository,
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
        private CreateStudyingMode          $CreateStudyingModeCase,
        private CreateCountry         $createCountryCase,
        private CreateCity         $createCityCase,
        private CreateExpertise          $createExpertiseCase,
        private GetDemoExpertisesList $GetDemoExpertisesList,
        private GetDemoCountriesList $GetDemoCountriesList,
        private GetDemoCitiesList $getDemoCitiesList,
        private GetAllCountries $GetAllCountriesCase,
        private GetAllPaymentTypes $GetAllPaymentTypes,
        private GetAllStudyingModes $GetAllStudyingModes,
        private GetAllUsers $GetAllUsersCases,
        private GetAllTeachers $getAllTeachersCase,
        private GetRandomDemoExpertises $GetRandomDemoExpertises,
        private AddStudyingModeToTeacher $addStudyingModeToTeacher,
        private AddPaymentTypeToTeacher $addPaymentTypeToTeacher,
        private GetDemoPaymentTypesList $demoPaymentTypesList,
        private GetDemoStudyingModesList $demoStudyingModesList,
        private CreateUser $createUserCase

    )
    {}

    #[Route('/test', name: 'test')]
    public function index(): Response
    {





        exit();

        //TODO работает
        $arPaymentTypes = $this->demoPaymentTypesList->execute();
        if (!empty($arPaymentTypes)) {
            foreach ($arPaymentTypes as $type) {
                $CreatePaymentTypeDTO = new CreatePaymentTypeDTO($type['name'], $type['code']);
                $this->CreatePaymentTypeCase->execute($CreatePaymentTypeDTO);
            }
        }

        //TODO работает
        $arStudyingModes = $this->demoStudyingModesList->execute();
        if (!empty($arStudyingModes)) {
            foreach ($arStudyingModes as $mode) {
                $CreatePaymentTypeDTO = new CreateStudyingModeDTO($mode['name'], $mode['code']);
                $this->CreateStudyingModeCase->execute($CreatePaymentTypeDTO);
            }
        }

        //TODO работает
        $arExpertises = $this->GetDemoExpertisesList->execute();
        if (!empty($arExpertises)) {
            foreach ($arExpertises as $expertise) {
                $expertiseDTO = new CreateExpertiseDTO($expertise['name'], $expertise['code']);
                $this->createExpertiseCase->execute($expertiseDTO);
            }
        }

        //TODO работает
        $arCountries = $this->GetDemoCountriesList->execute();
        if (!empty($arCountries)) {
            foreach ($arCountries as $isoCode => $name) {
                $countryDTO = new CreateCountryDTO($name, $isoCode);
                $this->createCountryCase->execute($countryDTO);
            }
        }


        //TODO работает
        $countries = $this->GetAllCountriesCase->executeEntities();
        $arCountries = [];
        foreach ($countries as $country) {
            $arCountries[$country->getIsoCode()] = $country;
        }

        $arCities = $this->getDemoCitiesList->execute();
        foreach ($arCities as $city) {
            $country = $arCountries[$city['country_iso_code']];
            $cityDTO = new CreateCityDTO($country, $city['name'], $city['code']);
            $this->createCityCase->execute($cityDTO);
        }


        //TODO работает

        UserFactory::createMany(5, ['roles' => GetUserRoles::executeForStudent()]);
        UserFactory::createMany(5, ['roles' => GetUserRoles::executeForTeacher()]);


        //TODO get Random row using Doctrine
        $arUsers = $this->GetAllUsersCases->executeEntities();
        if (!empty($arUsers)) {
            //TODO random genders
            foreach ($arUsers as $user) {
                if (in_array(GetUserRoles::getStudentRole(), CurrentUserRoles::execute($user))) {
                    StudentFactory::createOne(['related_user' => $user]);
                } elseif (in_array(GetUserRoles::getTeacherRole(), CurrentUserRoles::execute($user))) {
                    TeacherFactory::createOne(['related_user' => $user]);
                }
            }
        }



        //TODO работает

        $arRandomExpertises = $this->GetRandomDemoExpertises->execute();
        $arTeachers = $this->getAllTeachersCase->executeEntities();
        $arPaymentTypes = $this->GetAllPaymentTypes->executeEntities();
        $arStudyingMods = $this->GetAllStudyingModes->executeEntities();
//
//
//        dump($arRandomExpertises);
//        dump($arTeachers);
//        dump($arPaymentTypes);
//        dump($arStudyingMods);

        foreach ($arTeachers as $teacher) {
            CVFactory::createOne(['teacher' => $teacher]);

            //TODO made more random
            foreach ($arStudyingMods as $mode) {
                $this->addStudyingModeToTeacher->execute($teacher, $mode);
            }

            //TODO made more random
            foreach ($arPaymentTypes as $type) {
                $this->addPaymentTypeToTeacher->execute($teacher, $type);
            }



            $arAttachedExpertises = [];
            foreach ($arRandomExpertises as $expertise) {
                $expertiseId = $expertise->getId();
                if (!in_array($expertiseId, $arAttachedExpertises)) {
                    TeacherHasTeacherExpertisesFactory::createOne([
                        'teacher' => $teacher,
                        'expertise' => $expertise,
                    ]);
                    $arAttachedExpertises[] = $expertiseId;
                }
            }
        }


        exit();
    }

}
