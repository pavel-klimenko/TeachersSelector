<?php declare(strict_types=1);

namespace App\Application\Payment\Query;

use App\Application\Payment\DTO\ResponsePaymentDTO;
use App\Domain\Bus\Query\QueryResponse;
use App\Domain\Entity\Wallet;

final class GetPaymentQueryResponse implements QueryResponse
{
    public function __construct(private readonly ResponsePaymentDTO $DTO)
    {
    }

    public function id() : int
    {
        return $this->DTO->id;
    }

    public function sourceWallet() : Wallet
    {
        return $this->DTO->sourceWallet;
    }

    public function targetWallet() : Wallet
    {
        return $this->DTO->targetWallet;
    }

    public function sum() : float
    {
        return $this->DTO->sum;
    }
}

