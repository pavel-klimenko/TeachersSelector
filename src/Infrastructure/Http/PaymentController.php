<?php declare(strict_types=1);

namespace App\Infrastructure\Http\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\StripeService;

class PaymentController extends AbstractController
{
    public function createPaymentIntent(): JsonResponse
    {
        //$intent = $stripe->createPaymentIntent(10.00); // $10.00
        return new JsonResponse(['clientSecret' => 1]);
    }
}
