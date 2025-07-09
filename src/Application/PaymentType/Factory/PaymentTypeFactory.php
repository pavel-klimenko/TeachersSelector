<?php

namespace App\Application\PaymentType\Factory;

use App\Application\PaymentType\DTO\CreatePaymentTypeDTO;
use App\Domain\Entity\PaymentType;
use App\Domain\ValueObject\PaymentType\Code;
use App\Domain\ValueObject\PaymentType\Name;

class PaymentTypeFactory
{
    public static function makeObject(CreatePaymentTypeDTO $DTO): PaymentType
    {
        $name = new Name($DTO->name);
        $code = new Code($DTO->code);

        $paymentType = new PaymentType();
        $paymentType
            ->setName($name->getName())
            ->setCode($code->getCode());

        return $paymentType;
    }
}