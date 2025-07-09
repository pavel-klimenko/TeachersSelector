<?php declare(strict_types=1);

namespace App\Application\City\DTO;

use App\Domain\Entity\Country;

final class ResponseCityDTO
{
    public readonly int $id;
    public Country $country;
    public readonly string $name;
    public readonly string $code;

    public function __construct(
        int $id,
        Country $country,
        string $name,
        string $code,
    )
    {
        $this->id = $id;
        $this->country = $country;
        $this->name = $name;
        $this->code = $code;
    }
}