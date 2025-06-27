<?php

namespace App\DataFixtures;

use App\Domain\Entity\City;
use App\Domain\Entity\Country;
use App\Domain\Entity\Expertise;
use App\Domain\Entity\PaymentTypes;
use App\Domain\Entity\StudyingModels;
use App\Domain\Services\HelperService;
use App\Infrastructure\Repository\CountryRepository;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Domain\Repository\CityRepository;

class AppFixtures extends Fixture
{
    public function __construct(
        private CountryRepository $countryRepository,
        private HelperService $helperService
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

    }
}
