<?php

namespace App\Application\Teacher\Factory;


use App\Application\StudyingMode\DTO\CreateStudyingModeDTO;
use App\Application\Teacher\DTO\CreateTeacherDTO;
use App\Domain\Entity\StudyingMode;
use App\Domain\ValueObject\StudyingMode\Code;
use App\Domain\ValueObject\StudyingMode\Name;

class TeacherFactory
{
    public static function makeObject(CreateTeacherDTO $DTO): StudyingMode
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