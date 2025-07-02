<?php

namespace App\DataFixtures;

use App\Domain\Entity\City;
use App\Domain\Entity\Country;
use App\Domain\Entity\Expertise;
use App\Domain\Entity\PaymentTypes;
use App\Domain\Entity\StudyingModels;
use App\Domain\Factory\CVFactory;
use App\Domain\Factory\StudentFactory;
use App\Domain\Factory\TeacherFactory;
use App\Domain\Factory\TeacherHasTeacherExpertisesFactory;
use App\Domain\Factory\UserFactory;
use App\Domain\Services\HelperService;
use App\Infrastructure\Repository\CountryRepository;
use App\Infrastructure\Repository\ExpertiseRepository;
use App\Infrastructure\Repository\TeacherRepository;
use App\Infrastructure\Repository\UserRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function __construct(
        private ExpertiseRepository $expertiseRepository,
        private CountryRepository $countryRepository,
        private HelperService $helperService,
        private UserRepository $userRepository,
        private TeacherRepository $teacherRepository,
    )
    {}

    public function load(ObjectManager $manager): void
    {
        //TODO clen architecture and ValueObject, Factories

        $arPaymentTypes = $this->helperService->getJsonList('/public/json/payment_types.json');
        foreach ($arPaymentTypes as $type) {
            $newPaymentType = new PaymentTypes();
            $newPaymentType->setName($type['name'])->setCode($type['code']);
            $manager->persist($newPaymentType);
            $manager->flush();
        }

        $arStudyingModes = $this->helperService->getJsonList('/public/json/studying_modes.json');
        foreach ($arStudyingModes as $mode) {
            $newMode = new StudyingModels();
            $newMode->setName($mode['name'])->setCode($mode['code']);
            $manager->persist($newMode);
            $manager->flush();
        }


        $arExpertises = $this->helperService->getJsonList('/public/json/expertises.json');
        foreach ($arExpertises as $expertise) {
            $newExpertise = new Expertise();
            $newExpertise->setName($expertise['name'])->setCode($expertise['code']);
            $manager->persist($newExpertise);
            $manager->flush();
        }


        $arCountries = $this->helperService->getJsonList('/public/json/countries_iso_codes.json');
        foreach ($arCountries as $isoCode => $name) {
            $country = new Country();
            $country->setName($name)->setIsoCode($isoCode);
            $manager->persist($country);
            $manager->flush();
        }


        $countries = $this->countryRepository->findAll();
        $arCountries = [];
        foreach ($countries as $country) {
            $arCountries[$country->getIsoCode()] = $country;
        }

        $arCities = $this->helperService->getJsonList('/public/json/cities.json');
        foreach ($arCities as $city) {
            $country = $arCountries[$city['country_iso_code']];
            $newCity = new City();
            $newCity->setName($city['name'])->setCode($city['code'])->setCountry($country);
            $manager->persist($newCity);
            $manager->flush();
        }



        UserFactory::createMany(5, [
            'roles' => ['ROLE_USER', 'ROLE_STUDENT'],
        ]);

        UserFactory::createMany(5, [
            'roles' => ['ROLE_USER', 'ROLE_TEACHER'],
        ]);

        //TODO get Random row using Doctrine
        $arUsers = $this->userRepository->findAll();

        //TODO random genders

        foreach ($arUsers as $user) {
            if (in_array('ROLE_STUDENT', $user->getRoles())) {
                StudentFactory::createOne(['related_user' => $user]);
            } elseif (in_array('ROLE_TEACHER', $user->getRoles())) {
                TeacherFactory::createOne(['related_user' => $user]);
            }
        }


        $arTeachers = $this->teacherRepository->findAll();
        foreach ($arTeachers as $teacher) {
            CVFactory::createOne([
                'teacher' => $teacher,
            ]);
        }

        //Getting up to four random teacher`s expertises
        $arAllExpertisesIds = $this->expertiseRepository->findAll();
        if (!empty($arAllExpertisesIds)) {
            $min = 0;
            $max = count($arAllExpertisesIds) - 1;

            $arRandomExpertises = [];
            for ($i = 0; $i < 3; $i++) {
                $arRandomExpertises[] = $arAllExpertisesIds[rand($min, $max)];
            }
        }

        $arTeachers = $this->teacherRepository->findAll();
        foreach ($arTeachers as $teacher) {
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
