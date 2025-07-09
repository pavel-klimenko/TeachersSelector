<?php

namespace App\Application\Country\Factory;

use App\Application\Country\DTO\CreateCountryDTO;
use App\Domain\Entity\Country;
use App\Domain\ValueObject\Country\IsoCode;
use App\Domain\ValueObject\Country\Name;

class CountryFactory
{
    public static function makeObject(CreateCountryDTO $DTO): Country
    {
        $name = new Name($DTO->name);
        $isoCode = new IsoCode($DTO->isoCode);

        $country = new Country();
        $country
            ->setName($name->getName())
            ->setIsoCode($isoCode->getIsoCode());

        return $country;
    }
}