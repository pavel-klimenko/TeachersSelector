<?php declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\PaymentType;

interface PaymentTypeRepositoryInterface
{
    public function getList(): array;
    public function save(PaymentType $paymentType): void;
}