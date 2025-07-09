<?php

namespace App\Application\Teacher\UseCase;

use App\Domain\Repository\TeacherRepositoryInterface;

class SelectTeachers
{
    public function __construct(
        private TeacherRepositoryInterface $teacherRepository,
    ){}

    public function execute(array $arSelectFormData):array
    {
        $arFilter = $this->prepareFilter($arSelectFormData);
        $arTeachers = $this->teacherRepository->findTeachersByFilter($arFilter);

        return MakeArrayOfDTO::execute($arTeachers);
    }


    private function prepareFilter(array $arSelectFormData):array
    {
        $arFilter = [];
        $arFilter['rating'] = $arSelectFormData['rating'];
        $arFilter['maxRate'] = $arSelectFormData['maxHourRate'];
        $arFilter['yearsOfExperience'] = $arSelectFormData['yearsExperience'];
        $arFilter['studyingModeId'] = $arSelectFormData['studyingModes'];

        $arFilter['expertises_ids'] = [];
        if (!$arSelectFormData['expertises']->isEmpty()) {
            foreach ($arSelectFormData['expertises'] as $expertise) {
                $arFilter['expertises_ids'][] = $expertise->getId();
            }
        }
        return $arFilter;
    }
}