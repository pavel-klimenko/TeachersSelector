<?php declare(strict_types=1);

namespace App\Application\City\UseCase;

use App\Domain\Entity\City;
use App\Domain\Services\HelperServiceInterface;

class GetDemoCitiesList
{
    public function __construct(
        private HelperServiceInterface $helperService,
    ){}

    public function execute()
    {
        return $this->helperService->getJsonList(City::COUNTRIES_JSON);
    }
}