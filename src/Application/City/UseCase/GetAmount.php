<?php declare(strict_types=1);

namespace App\Application\City\UseCase;

use App\Domain\Repository\CityRepositoryInterface;

class GetAmount
{
    public function __construct(
        private CityRepositoryInterface $cityRepository,
    ){}

    public function execute():int
    {
        return $this->cityRepository->getAmount();
    }
}