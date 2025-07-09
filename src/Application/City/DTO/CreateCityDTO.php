<?php declare(strict_types=1);

namespace App\Application\City\DTO;

use App\Domain\Entity\Country;

final class CreateCityDTO
{
    public Country $country;
    public readonly string $name;
    public readonly string $code;

    public function __construct(
        Country $country,
        string $name,
        string $code,
    )
    {
        $this->country = $country;
        $this->name = $name;
        $this->code = $code;
    }
}