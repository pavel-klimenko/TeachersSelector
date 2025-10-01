<?php declare(strict_types=1);

namespace App\Application\Payment\Query;

use App\Application\Payment\DTO\ResponsePaymentDTO;
use App\Domain\Bus\Query\QueryHandler;
use App\Domain\Bus\Query\QueryResponse;
use App\Domain\Repository\PaymentRepositoryInterface;

final class GetPaymentQueryHandler implements QueryHandler
{
    public function __construct(
        private PaymentRepositoryInterface $paymentRepository,
    ){}

    public function __invoke(GetPaymentQuery $query) : QueryResponse
    {
        $payment = $this->paymentRepository->find(
            $query->id(),
        );

        if (is_null($payment)) {
            throw new \RuntimeException('Payment not found');
        }

        $dto = new ResponsePaymentDTO(
            $payment->getId(),
            $payment->getSourceWallet(),
            $payment->getTargetWallet(),
            $payment->getSum(),
        );

        return new GetPaymentQueryResponse($dto);
    }
}

