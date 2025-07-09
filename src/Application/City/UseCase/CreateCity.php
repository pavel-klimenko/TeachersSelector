<?php declare(strict_types=1);

namespace App\Application\City\UseCase;

use App\Application\City\DTO\CreateCityDTO;
use App\Application\City\DTO\ResponseCityDTO;
use App\Application\City\Factory\CityFactory;
use App\Domain\Repository\CityRepositoryInterface;

class CreateCity
{
    public function __construct(
        private CityRepositoryInterface $cityRepository,
    ){}

    public function execute(CreateCityDTO $DTO):ResponseCityDTO
    {
        $newCity = CityFactory::makeObject($DTO);
        $this->cityRepository->save($newCity);

        return new ResponseCityDTO(
            $newCity->getId(),
            $newCity->getCountry(),
            $newCity->getName(),
            $newCity->getCode(),
        );
    }
}