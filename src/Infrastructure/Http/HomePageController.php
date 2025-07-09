<?php declare(strict_types=1);

namespace App\Infrastructure\Http;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Cache\CacheInterface;
use App\Application\Expertise\UseCase\GetAllExpertises as GetAllExpertises;
use App\Application\PaymentType\UseCase\GetAllPaymentTypes as GetAllPaymentTypes;
use App\Application\City\UseCase\GetAmount as GetCitiesAmount;
use App\Application\Student\UseCase\GetAmount as GetStudentAmount;

final class HomePageController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(
        CacheInterface $cache,
        GetAllExpertises $GetAllExpertisesCase,
        GetAllPaymentTypes $GetAllPaymentTypesCase,
        GetCitiesAmount $GetCitiesAmountCase,
        GetStudentAmount $GetStudentAmountCase,
    ): Response
    {
        $arExpertises = $cache->get('expertises_all', function () use ($GetAllExpertisesCase) {
            return $GetAllExpertisesCase->execute();
        });

        $arPaymentTypes = $cache->get('payment_types_all', function () use ($GetAllPaymentTypesCase) {
            return $GetAllPaymentTypesCase->executeDTOs();
        });

        $citiesAmount = $cache->get('cities_amount', function () use ($GetCitiesAmountCase) {
            return $GetCitiesAmountCase->execute();
        });

        $studentsAmount = $cache->get('students_amount', function () use ($GetStudentAmountCase) {
            return $GetStudentAmountCase->execute();
        });

        return $this->render('homepage.html.twig', [
            'title' => 'Homepage',
            'expertises' => $arExpertises,
            'payment_types' => $arPaymentTypes,
            'cities_amount' => $citiesAmount,
            'students_amount' => $studentsAmount,
        ]);
    }
}
