<?php declare(strict_types=1);

namespace App\Application\Payment\DTO;

use App\Domain\Entity\Wallet;

final class CreatePaymentDTO
{
    public readonly Wallet $sourceWallet;
    public readonly Wallet $targetWallet;

    public readonly float $sum;

    public function __construct(
        Wallet $sourceWallet,
        Wallet $targetWallet,
        float $sum
    )
    {
        $this->sourceWallet = $sourceWallet;
        $this->targetWallet = $targetWallet;
        $this->sum = $sum;
    }
}