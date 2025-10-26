<?php

namespace App\Infrastructure\Services;

use RuntimeException;
use Stripe\Stripe;
use Stripe\PaymentIntent;


//TODO Add Interface

class StripeService
{
    //TODO make autowire arguments
    // public function __construct()
    // {
    //     $secretKey = $_ENV['STRIPE_SECRET_KEY'] ?? null;

    //     if (!$secretKey) {
    //         throw new RuntimeException('STRIPE_SECRET_KEY not found in .env');
    //     }

    //     Stripe::setApiKey($secretKey);
    // }

        private $apiKey;

    private $stripeService;

    public function __construct()
    {
        //require_once __DIR__ . '/../Config.php';
        $this->apiKey = $_ENV['STRIPE_SECRET_KEY'];
        $this->stripeService = new Stripe();
        $this->stripeService->setVerifySslCerts(false);
        $this->stripeService->setApiKey($this->apiKey);
    }

    // public function createPaymentIntent(float $amount): PaymentIntent
    // {
    //     return PaymentIntent::create([
    //         'amount' => $amount * 100,
    //         'currency' => 'usd',
    //         'payment_method_types' => ['card'],
    //     ]);
    // }

    // public function retrievePaymentIntent(string $id): PaymentIntent
    // {
    //     return PaymentIntent::retrieve($id);
    // }

        public function createPaymentIntent($orderReferenceId, $amount, $currency, $email, $customerDetailsArray, $notes, $metaData){
        try {
            $this->stripeService->setApiKey($this->apiKey);


            //TODO set these params automatically, from users personal area

            $paymentIntent = \Stripe\PaymentIntent::create([
                'description' => $notes,
                'shipping' => [
                    'name' => $customerDetailsArray["name"],
                    'address' => [
                        'line1' => $customerDetailsArray["address"],
                        'postal_code' => $customerDetailsArray["postalCode"],
                        'country' => $customerDetailsArray["country"]
                    ]
                ],
                'amount' => $amount * 100,
                'currency' => $currency,
                'payment_method_types' => [
                    'card'
                ],
                'metadata' => $metaData
            ]);
            $output = array(
                "status" => "success",
                "response" => array('orderHash' => $orderReferenceId, 'clientSecret'=>$paymentIntent->client_secret)
            );
        } catch (\Error $e) {
            $output = array(
                "status" => "error",
                "response" => $e->getMessage()
            );
        }
        return $output;
    }

    public function getToken()
    {
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet .= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet .= "0123456789";
        $max = strlen($codeAlphabet) - 1;
        for ($i = 0; $i < 17; $i ++) {
            $token .= $codeAlphabet[mt_rand(0, $max)];
        }
        return $token;
    }
}