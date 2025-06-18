<?php

namespace App\Domain\ValueObject\TeacherStudyingCategories;

use App\Domain\Entity\StudyingCategories;

class StudyingCategory
{
    public function __construct(
        private StudyingCategories $studyingCategory,
    ){}
}