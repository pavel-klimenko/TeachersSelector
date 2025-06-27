<?php

namespace App\Infrastructure\Http;

use App\Domain\Entity\Country;
use App\Domain\Repository\CityRepository;
use App\Domain\Services\HelperService;
use App\Infrastructure\Repository\CountryRepository;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\SerializerInterface;

final class TestController extends AbstractController
{

    public function __construct(private CountryRepository $countryRepository)
    {}

    #[Route('/test', name: 'test')]
    public function index(): Response
    {



        $helperService = new HelperService();

        $arCities = $helperService->getCities();

        foreach ($arCities as $city) {
            dd($city['name']);
//            $country = new Country();
//            $country->setName($name)->setIsoCode($isoCode);
//            $manager->persist($country);
//            $manager->flush();
        }


        exit();
    }


    function getCountries()
    {

    }

}
