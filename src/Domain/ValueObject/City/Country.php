<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\City;
final class Country
{
    public function __construct(
        private Country $country,
    ){}
}
