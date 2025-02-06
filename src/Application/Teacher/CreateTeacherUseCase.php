<?php

declare(strict_types=1);

namespace App\Application\Teacher;

use App\Domain\Entity\Teacher;
use App\Domain\Repository\TeacherRepositoryInterface;
use App\Domain\ValueObject\Teacher\Age;
use App\Domain\ValueObject\Teacher\Gender;
use App\Domain\ValueObject\Teacher\Name;
use App\Domain\ValueObject\Teacher\Salary;

class CreateTeacherUseCase
{
    public function __construct(
        private TeacherRepositoryInterface $teacherRepository
    ){}

    public function execute()
    {
        $worker = new Teacher(
          new Age(24),
          new Gender('MALE'),
          new Name('Pavel', 'Klimenko', 'Alexandrovich'),
          new Salary(2400),
        );

        $this->teacherRepository->add($worker);
    }

}
