<?php declare(strict_types=1);

namespace App\Application\Country\UseCase;

use App\Domain\Entity\Country;
use App\Domain\Services\HelperServiceInterface;

class GetDemoCountriesList
{
    public function __construct(
        private HelperServiceInterface $helperService,
    ){}

    public function execute()
    {
        return $this->helperService->getJsonList(Country::COUNTRIES_JSON);
    }
}