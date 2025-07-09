<?php declare(strict_types=1);

namespace App\Application\Teacher\UseCase;
use App\Application\Teacher\DTO\ResponseTeacherDTO;

class MakeArrayOfDTO
{
    public static function execute(array $arTeachers):array
    {
        $arDtoTeachers = [];
        if (!empty($arTeachers)) {
            foreach ($arTeachers as $el) {
                $arDtoTeachers[] = new ResponseTeacherDTO(
                    $el->getId(),
                    $el->getRating(),
                    $el->getCv(),
                    $el->getTeacherHasTeacherExpertises(),
                    $el->getRelatedUser(),
                    $el->getStudyingModes(),
                    $el->getPaymentTypes()
                );
            }
        }

        return $arDtoTeachers;
    }
}