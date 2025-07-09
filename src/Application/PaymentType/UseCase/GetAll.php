<?php declare(strict_types=1);

namespace App\Application\PaymentType\UseCase;

use App\Application\PaymentType\DTO\ResponsePaymentTypeDTO;
use App\Domain\Repository\PaymentTypeRepositoryInterface;

class GetAll
{
    public function __construct(
        private PaymentTypeRepositoryInterface $paymentTypeRepository,
    ){}

    public function execute():array
    {
        $arPaymentTypes = $this->paymentTypeRepository->getList();

        $arDtoPaymentTypes = [];
        if (!empty($arPaymentTypes)) {
            foreach ($arPaymentTypes as $el) {
                $arDtoPaymentTypes[] = new ResponsePaymentTypeDTO(
                    $el->getId(),
                    $el->getName(),
                    $el->getCode(),
                );
            }
        }

        return $arDtoPaymentTypes;
    }
}