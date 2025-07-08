<?php declare(strict_types=1);

namespace App\Application\Teacher\UseCase;
use App\Application\Teacher\DTO\ResponseTeacherDTO;
use App\Domain\Repository\TeacherRepositoryInterface;

class GetAll
{
    public function __construct(
        private TeacherRepositoryInterface $teacherRepository,
    ){}

    public function execute():array
    {
        $arTeachers = $this->teacherRepository->getList();

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