<?php declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Country;

interface CountryRepositoryInterface
{
    public function save(Country $country): void;
}