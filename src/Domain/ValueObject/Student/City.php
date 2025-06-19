<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\Student;

use  App\Domain\Entity\City as CityEntity;
final class City
{
    public function __construct(
        private CityEntity $city,
    ){}
}