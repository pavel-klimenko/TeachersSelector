<?php declare(strict_types=1);

namespace App\Domain\Repository;

interface PaymentTypeRepositoryInterface
{
    public function getList(): array;
}