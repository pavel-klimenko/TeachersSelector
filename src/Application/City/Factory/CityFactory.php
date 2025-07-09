<?php

namespace App\Application\City\Factory;

use App\Application\City\DTO\CreateCityDTO;
use App\Domain\Entity\City;
use App\Domain\ValueObject\City\Name;
use App\Domain\ValueObject\City\Code;
class CityFactory
{
    public static function makeObject(CreateCityDTO $DTO): City
    {
        $name = new Name($DTO->name);
        $code = new Code($DTO->code);

        $city = new City();
        $city
            ->setCountry($DTO->country)
            ->setCode($code->getCode())
            ->setName($name->getName());

        return $city;
    }
}