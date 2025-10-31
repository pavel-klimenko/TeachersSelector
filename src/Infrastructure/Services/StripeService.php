<?php

namespace App\Infrastructure\Services;

use App\Domain\Enums\Currencies;
use Stripe\Stripe;
use Stripe\PaymentIntent;


class StripeService
{
    private $apiKey;
    private $stripeService;

    public function __construct()
    {
        $this->apiKey = $_ENV['STRIPE_SECRET_KEY'];
        $this->stripeService = new Stripe();
        $this->stripeService->setVerifySslCerts(false);
        $this->stripeService->setApiKey($this->apiKey);
    }

     public function createPaymentIntent(float $amount, array $arMetaData): PaymentIntent
     {
         return PaymentIntent::create([
             'amount' => $amount * 100,
             'currency' => Currencies::USD->value,
             'payment_method_types' => ['card'],
             'metadata' => $arMetaData
         ]);
     }

     public function retrievePaymentIntent(string $id): PaymentIntent
     {
         return PaymentIntent::retrieve($id);
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