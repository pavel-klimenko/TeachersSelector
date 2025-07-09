<?php declare(strict_types=1);

namespace App\Application\StudyingMode\UseCase;

use App\Domain\Entity\StudyingMode;
use App\Domain\Services\HelperServiceInterface;

class GetDemoStudyingModesList
{
    public function __construct(
        private HelperServiceInterface $helperService,
    ){}

    public function execute()
    {
        return $this->helperService->getJsonList(StudyingMode::STUDYING_MODES_JSON);
    }
}