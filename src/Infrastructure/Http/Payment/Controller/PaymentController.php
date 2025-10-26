<?php declare(strict_types=1);

namespace App\Infrastructure\Http\Payment\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Service\StripeService;
use Symfony\Component\HttpFoundation\Request;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;
use UnexpectedValueException;

class PaymentController extends AbstractController
{

    #[Route('/stripe-show-payment-from', name: 'stripe-show-payment-from')]
    public function showPaymentFrom(): Response
    {
        //$intent = $stripe->createPaymentIntent(10.00); // $10.00
        //return new JsonResponse(['clientSecret' => 1]);

        return $this->render('payments/stripe/stripePaymentForm.html.twig', [
            'title' => 'Stripe payment form',
            // 'expertises' => $arExpertises,
            // 'payment_types' => $arPaymentTypes,
            // 'cities_amount' => $citiesAmount,
            // 'students_amount' => $studentsAmount,
            // 'html_data'=> $GetHomePageHtmlData->execute()
        ]);
    }


    public function createPaymentIntent(): JsonResponse
    {
        //$intent = $stripe->createPaymentIntent(10.00); // $10.00
        return new JsonResponse(['clientSecret' => 1]);
    }

    #[Route('/stripe-webhook-handle', name: 'stripe-webhook-handle', methods: ['POST'])]
    public function handle(Request $request): Response
    {
        $endpointSecret = $_ENV['STRIPE_WEBHOOK_ENDPOINT'];
        $payload = $request->getContent();
        $sigHeader = $request->headers->get('Stripe-Signature');
        $event = null;

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (UnexpectedValueException $e) {
            return new Response('Invalid payload', 400);
        } catch (SignatureVerificationException $e) {
            return new Response('Invalid signature', 400);
        }

        // Handle specific event types
        switch ($event->type) {
            case 'payment_intent.succeeded':
                $paymentIntent = $event->data->object;
                // Handle successful payment
                break;

            case 'charge.failed':
                $charge = $event->data->object;
                // Handle failed charge
                break;

            default:
                // Log or ignore other events
                break;
        }

        return new Response('Webhook received', 200);
    }
}
