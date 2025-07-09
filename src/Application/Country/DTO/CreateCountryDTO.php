<?php declare(strict_types=1);

namespace App\Application\Country\DTO;

final class CreateCountryDTO
{
    public readonly string $name;
    public readonly string $isoCode;
    public function __construct(
        string $name,
        string $isoCode,
    )
    {
        $this->name = $name;
        $this->isoCode = $isoCode;
    }
}