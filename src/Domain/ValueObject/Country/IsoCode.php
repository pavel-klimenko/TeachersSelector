<?php declare(strict_types=1);

namespace App\Domain\ValueObject\Country;


final class IsoCode
{
    public function __construct(
        private string $isoCode,
    ){}

    public function getIsoCode(): string
    {
        return $this->isoCode;
    }
}

