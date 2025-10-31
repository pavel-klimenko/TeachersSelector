<?php

namespace App\Domain\Services;

use App\Application\Payment\DTO\RegisterPaymentDTO;

interface PaymentServiceInterface
{
    //TODO user here response payment register DTO
    public function registerPayment(RegisterPaymentDTO $DTO);
}