<?php declare(strict_types=1);

namespace App\Application\Teacher\UseCase;
use App\Application\Teacher\DTO\ResponseTeacherDTO;
use App\Domain\Repository\TeacherRepositoryInterface;

class GetOne
{
    public function __construct(
        private TeacherRepositoryInterface $teacherRepository,
    ){}

    public function execute(int $id):ResponseTeacherDTO|null
    {
        if ($teacher = $this->teacherRepository->getTeacher($id)) {
            $responseTeacher = new ResponseTeacherDTO(
                $teacher->getId(),
                $teacher->getRating(),
                $teacher->getCv(),
                $teacher->getTeacherHasTeacherExpertises(),
                $teacher->getRelatedUser(),
                $teacher->getStudyingModes(),
                $teacher->getPaymentTypes()
            );
        } else {
            $responseTeacher = null;
        }

        return $responseTeacher;
    }
}