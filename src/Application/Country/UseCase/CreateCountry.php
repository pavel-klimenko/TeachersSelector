<?php declare(strict_types=1);

namespace App\Application\Country\UseCase;

use App\Application\Country\DTO\CreateCountryDTO;
use App\Application\Country\DTO\ResponseCountryDTO;
use App\Application\Country\Factory\CountryFactory;
use App\Domain\Repository\CountryRepositoryInterface;

class CreateCountry
{
    public function __construct(
        private CountryRepositoryInterface $countryRepository,
    ){}

    public function execute(CreateCountryDTO $DTO):ResponseCountryDTO
    {
        $newCountry = CountryFactory::makeObject($DTO);
        $this->countryRepository->save($newCountry);

        return new ResponseCountryDTO(
            $newCountry->getId(),
            $newCountry->getName(),
            $newCountry->getIsoCode(),
        );
    }
}