<?php declare(strict_types=1);

namespace App\Domain\Repository;

interface CityRepositoryInterface
{
    public function getAmount(): int;
}