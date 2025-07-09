<?php

namespace App\Application\StudyingMode\Factory;


use App\Application\StudyingMode\DTO\CreateStudyingModeDTO;
use App\Domain\Entity\StudyingMode;
use App\Domain\ValueObject\StudyingMode\Code;
use App\Domain\ValueObject\StudyingMode\Name;

class StudyingModeFactory
{
    public static function makeObject(CreateStudyingModeDTO $DTO): StudyingMode
    {
        $name = new Name($DTO->name);
        $code = new Code($DTO->code);

        $studyingMode = new StudyingMode();
        $studyingMode
            ->setName($name->getName())
            ->setCode($code->getCode());

        return $studyingMode;
    }
}