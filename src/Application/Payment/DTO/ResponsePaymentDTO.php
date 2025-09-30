<?php declare(strict_types=1);

namespace App\Application\Payment\DTO;

use App\Domain\Entity\Wallet;

final class ResponsePaymentDTO
{
    public readonly int $id;
    public readonly Wallet $sourceWallet;
    public readonly Wallet $targetWallet;

    public readonly float $sum;

    public function __construct(
        int $id,
        Wallet $sourceWallet,
        Wallet $targetWallet,
        float $sum,
    )
    {
        $this->id = $id;
        $this->sourceWallet = $sourceWallet;
        $this->targetWallet = $targetWallet;
        $this->sum = $sum;
    }
}