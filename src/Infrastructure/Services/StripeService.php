<?php

namespace App\Infrastructure\Services;

use RuntimeException;
use Stripe\Stripe;
use Stripe\PaymentIntent;


//TODO Add Interface

class StripeService
{
    //TODO make autowire arguments
    public function __construct()
    {
        $secretKey = $_ENV['STRIPE_SECRET_KEY'] ?? null;

        if (!$secretKey) {
            throw new RuntimeException('STRIPE_SECRET_KEY not found in .env');
        }

        Stripe::setApiKey($secretKey);
    }

    public function createPaymentIntent(float $amount): PaymentIntent
    {
        return PaymentIntent::create([
            'amount' => $amount * 100,
            'currency' => 'usd',
            'payment_method_types' => ['card'],
        ]);
    }

    public function retrievePaymentIntent(string $id): PaymentIntent
    {
        return PaymentIntent::retrieve($id);
    }
}