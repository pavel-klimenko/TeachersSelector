<?php declare(strict_types=1);

namespace App\Application\Teacher\UseCase;
use App\Domain\Entity\PaymentType;
use App\Domain\Entity\Teacher;
use App\Domain\Repository\TeacherRepositoryInterface;

class AddPaymentTypeToTeacher
{
    public function __construct(
        private TeacherRepositoryInterface $teacherRepository,
    ){}

    public function execute(Teacher $teacher, PaymentType $paymentType):void
    {
        $teacher->addPaymentType($paymentType);
        $this->teacherRepository->save($teacher);
    }
}