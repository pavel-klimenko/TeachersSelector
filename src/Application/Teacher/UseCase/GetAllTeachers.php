<?php declare(strict_types=1);

namespace App\Application\Teacher\UseCase;
use App\Domain\Repository\TeacherRepositoryInterface;

class GetAllTeachers
{
    public function __construct(
        private TeacherRepositoryInterface $teacherRepository,
    ){}

    public function executeDTOs():array
    {
        $arTeachers = $this->teacherRepository->getList();
        return MakeArrayOfDTO::execute($arTeachers);
    }

    public function executeEntities():array
    {
        return $this->teacherRepository->getList();
    }
}