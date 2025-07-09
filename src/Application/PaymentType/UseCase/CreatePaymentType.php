<?php declare(strict_types=1);

namespace App\Application\PaymentType\UseCase;

use App\Application\PaymentType\DTO\CreatePaymentTypeDTO;
use App\Application\PaymentType\DTO\ResponsePaymentTypeDTO;
use App\Application\PaymentType\Factory\PaymentTypeFactory;
use App\Domain\Repository\PaymentTypeRepositoryInterface;

class CreatePaymentType
{
    public function __construct(
        private PaymentTypeRepositoryInterface $paymentTypeRepository,
    ){}

    public function execute(CreatePaymentTypeDTO $DTO):ResponsePaymentTypeDTO
    {
        $newPaymentType = PaymentTypeFactory::makeObject($DTO);
        $this->paymentTypeRepository->save($newPaymentType);

        return new ResponsePaymentTypeDTO(
            $newPaymentType->getId(),
            $newPaymentType->getName(),
            $newPaymentType->getCode(),
        );
    }
}