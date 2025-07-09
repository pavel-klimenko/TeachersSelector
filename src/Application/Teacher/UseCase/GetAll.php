<?php declare(strict_types=1);

namespace App\Application\Teacher\UseCase;
use App\Domain\Repository\TeacherRepositoryInterface;

class GetAll
{
    public function __construct(
        private TeacherRepositoryInterface $teacherRepository,
    ){}

    public function execute():array
    {
        $arTeachers = $this->teacherRepository->getList();

        return MakeArrayOfDTO::execute($arTeachers);
    }
}