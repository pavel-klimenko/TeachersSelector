<?php declare(strict_types=1);

namespace App\Infrastructure\Http;

use App\Infrastructure\Repository\CityRepository;
use App\Infrastructure\Repository\ExpertiseRepository;
use App\Infrastructure\Repository\PaymentTypesRepository;
use App\Infrastructure\Repository\StudentRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

final class HomePageController extends AbstractController
{
    #[Route('/', name: 'homepage')]
    public function index(
        CacheInterface $cache,
        ExpertiseRepository $expertiseRepository,
        PaymentTypesRepository $paymentTypesRepository,
        CityRepository $cityRepository,
        StudentRepository $studentRepository,
    ): Response
    {
        $arExpertises = $cache->get('expertises_all', function () use ($expertiseRepository) {
            return $expertiseRepository->findAll();
        });

        $arPaymentTypes = $cache->get('payment_types_all', function () use ($paymentTypesRepository) {
            return $paymentTypesRepository->findAll();
        });

        $citiesAmount = $cache->get('cities_amount', function () use ($cityRepository) {
            return $cityRepository->count();
        });

        $studentsAmount = $cache->get('students_amount', function () use ($studentRepository) {
            return $studentRepository->count();
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
