<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Payment;

interface PaymentRepositoryInterface
{
    public function save(Payment $payment): Payment;
}
