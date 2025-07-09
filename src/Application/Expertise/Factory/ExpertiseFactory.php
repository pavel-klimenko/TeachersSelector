<?php

namespace App\Application\Expertise\Factory;

use App\Application\Expertise\DTO\CreateExpertiseDTO;
use App\Domain\Entity\Expertise;
use App\Domain\ValueObject\Expertise\Code;
use App\Domain\ValueObject\Expertise\Name;

class ExpertiseFactory
{
    public static function makeObject(CreateExpertiseDTO $DTO): Expertise
    {
        $name = new Name($DTO->name);
        $code = new Code($DTO->code);

        $expertise = new Expertise();
        $expertise
            ->setName($name->getName())
            ->setCode($code->getCode());

        return $expertise;
    }
}