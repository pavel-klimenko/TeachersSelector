<?php

namespace App\DataFixtures;

use App\Application\City\DTO\CreateCityDTO;
use App\Application\City\UseCase\CreateCity;
use App\Application\City\UseCase\GetDemoCitiesList;
use App\Application\Country\DTO\CreateCountryDTO;
use App\Application\Country\UseCase\CreateCountry;
use App\Application\Country\UseCase\GetAllCountries;
use App\Application\Country\UseCase\GetDemoCountriesList;
use App\Application\Expertise\DTO\CreateExpertiseDTO;
use App\Application\Expertise\UseCase\CreateExpertise;
use App\Application\Expertise\UseCase\GetDemoExpertisesList;
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
use App\Application\User\UseCase\CurrentUserRoles;
use App\Application\User\UseCase\GetAllUsers;
use App\Application\User\UseCase\GetUserRoles;
use App\Domain\Factory\CVFactory;
use App\Domain\Factory\StudentFactory;
use App\Domain\Factory\TeacherFactory;
use App\Domain\Factory\TeacherHasTeacherExpertisesFactory;
use App\Domain\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function __construct(
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
        private GetDemoStudyingModesList $demoStudyingModesList
    )
    {}

    public function load(ObjectManager $manager): void
    {
        //TODO разбить на разные фикстуры
        //TODO фикстуры на слой Infrastructure


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

    }
}
