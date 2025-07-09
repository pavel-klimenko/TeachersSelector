<?php declare(strict_types=1);

namespace App\Application\StudyingMode\UseCase;
use App\Domain\Repository\StudyingModeRepositoryInterface;

class GetAllStudyingModes
{
    public function __construct(
        private StudyingModeRepositoryInterface $studyingModeRepository,
    ){}


    public function executeEntities():array
    {
        return $this->studyingModeRepository->getList();
    }
}