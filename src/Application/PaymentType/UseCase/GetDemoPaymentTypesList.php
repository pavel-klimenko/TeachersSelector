<?php declare(strict_types=1);

namespace App\Application\PaymentType\UseCase;

use App\Domain\Entity\PaymentType;
use App\Domain\Services\HelperServiceInterface;

class GetDemoPaymentTypesList
{
    public function __construct(
        private HelperServiceInterface $helperService,
    ){}

    public function execute()
    {
        return $this->helperService->getJsonList(PaymentType::PAYMENT_TYPES_JSON);
    }
}