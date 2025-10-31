<?php declare(strict_types=1);

namespace App\Infrastructure\Http\Payment\Controller;

use App\Application\Payment\DTO\registerPaymentDTO;
use App\Domain\Enums\Currencies;
use App\Domain\Services\PaymentServiceInterface;
use App\Infrastructure\Form\FillWalletForm;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;
use Symfony\Component\Form\FormFactoryInterface;
use UnexpectedValueException;

class PaymentController extends AbstractController
{
    #[Route('/stripe-show-payment-from', name: 'stripe-show-payment-from')]
    public function showPaymentFrom(
        Request $request,
        FormFactoryInterface $formFactory,
        PaymentServiceInterface $paymentService,
    ): Response
    {
        try {
            /** @var \App\Domain\Entity\User|null $user */
            $user = $this->getUser();

            $form = $formFactory->create(FillWalletForm::class, null, [
                'user_email' => $user?->getEmail(),
                'user_name' => $user?->getName(),
            ]);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $arFormData = $form->getData();
                $paymentDTO = new RegisterPaymentDTO(
                    $arFormData['amount'],
                    Currencies::USD,
                    $arFormData['user_email'],
                    $arFormData['user_name']
                );

                $arRegPaymentResult = $paymentService->registerPayment($paymentDTO);

                return $this->render('payments/paymentRegistered.html.twig', [
                    'title' => 'Payment registered',
                    'registered_payment_id' => $arRegPaymentResult['id'],
                    'amount' => $paymentDTO->sum,
                    'currency' => $paymentDTO->currency->value,
                ]);
            }

            return $this->render('payments/stripe/stripePaymentForm.html.twig', [
                'title' => 'Fill the wallet',
                'FillWalletForm' => $form->createView(),
            ]);
        } catch (\Exception $exception) {
            print_r($exception);
        }
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
