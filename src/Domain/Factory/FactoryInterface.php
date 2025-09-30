<?php

namespace App\Domain\Factory;

use App\Domain\DTO\CreateDTOInterface;

interface FactoryInterface
{
    public static function makeObject(CreateDTOInterface $DTO);
}
