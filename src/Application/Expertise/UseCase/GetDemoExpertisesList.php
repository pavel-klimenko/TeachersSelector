<?php declare(strict_types=1);

namespace App\Application\Expertise\UseCase;

use App\Domain\Entity\Expertise;
use App\Domain\Services\HelperServiceInterface;

class GetDemoExpertisesList
{
    public function __construct(
        private HelperServiceInterface $helperService,
    ){}

    public function execute()
    {
        return $this->helperService->getJsonList(Expertise::EXPERTISES_JSON);
    }
}