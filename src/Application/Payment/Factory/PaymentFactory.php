<?php

namespace App\Application\Payment\Factory;

use App\Domain\Entity\Payment;
use App\Application\Payment\DTO\CreatePaymentDTO;

class PaymentFactory
{
    public static function makeObject(CreatePaymentDTO $DTO): Payment
    {
        $payment = new Payment();
        $payment
            ->setSourceWallet($DTO->sourceWallet)
            ->setTargetWallet($DTO->targetWallet)
            ->setSum($DTO->sum);

        return $payment;
    }
}