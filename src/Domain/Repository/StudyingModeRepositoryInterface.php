<?php declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\StudyingMode;

interface StudyingModeRepositoryInterface
{
    public function save(StudyingMode $studyingMode): void;
}