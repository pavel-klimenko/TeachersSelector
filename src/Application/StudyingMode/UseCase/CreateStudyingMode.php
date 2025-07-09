<?php declare(strict_types=1);

namespace App\Application\StudyingMode\UseCase;

use App\Application\PaymentType\DTO\CreatePaymentTypeDTO;
use App\Application\PaymentType\DTO\ResponsePaymentTypeDTO;
use App\Application\StudyingMode\DTO\CreateStudyingModeDTO;
use App\Application\StudyingMode\DTO\ResponseStudyingModeDTO;
use App\Application\StudyingMode\Factory\StudyingModeFactory;
use App\Domain\Repository\PaymentTypeRepositoryInterface;
use App\Application\PaymentType\Factory\ExpertiseFactory;
use App\Domain\Repository\StudyingModeRepositoryInterface;

class CreateStudyingMode
{
    public function __construct(
        private StudyingModeRepositoryInterface $studyingModeRepository,
    ){}

    public function execute(CreateStudyingModeDTO $DTO):ResponseStudyingModeDTO
    {
        $newStudyingMode = StudyingModeFactory::makeObject($DTO);
        $this->studyingModeRepository->save($newStudyingMode);

        return new ResponseStudyingModeDTO(
            $newStudyingMode->getId(),
            $newStudyingMode->getName(),
            $newStudyingMode->getCode(),
        );
    }
}