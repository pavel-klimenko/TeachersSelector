<?php declare(strict_types=1);

namespace App\Application\Teacher\UseCase;
use App\Domain\Entity\StudyingMode;
use App\Domain\Entity\Teacher;
use App\Domain\Repository\TeacherRepositoryInterface;

class AddStudyingModeToTeacher
{
    public function __construct(
        private TeacherRepositoryInterface $teacherRepository,
    ){}

    public function execute(Teacher $teacher, StudyingMode $studyingMode):void
    {
        $teacher->addStudyingMode($studyingMode);
        $this->teacherRepository->save($teacher);
    }
}