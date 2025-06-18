<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\TeacherStudyingCategories;
final class Teacher
{
    public function __construct(
        private Teacher $teacher,
    ){}
}