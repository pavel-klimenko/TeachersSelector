<?php declare(strict_types=1);

namespace App\Application\Country\DTO;

final class ResponseCountryDTO
{
    public readonly int $id;
    public readonly string $name;
    public readonly string $isoCode;
    public function __construct(
        int $id,
        string $name,
        string $isoCode,
    )
    {
        $this->id = $id;
        $this->name = $name;
        $this->isoCode = $isoCode;
    }
}