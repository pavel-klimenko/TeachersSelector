<?php declare(strict_types=1);

namespace App\Application\Country\UseCase;
use App\Application\Country\DTO\ResponseCountryDTO;
use App\Domain\Repository\CountryRepositoryInterface;

class GetAllCountries
{
    public function __construct(
        private CountryRepositoryInterface $countryRepository,
    ){}

    public function executeDTOs():array
    {
        $arCountries = $this->countryRepository->getList();

        $arDtoCountries = [];
        if (!empty($arCountries)) {
            foreach ($arCountries as $el) {
                $arDtoCountries[] = new ResponseCountryDTO(
                    $el->getId(),
                    $el->getName(),
                    $el->getIsoCode(),
                );
            }
        }
        return $arDtoCountries;
    }

    public function executeEntities():array
    {
        return $this->countryRepository->getList();
    }
}