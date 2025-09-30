<?php declare(strict_types=1);

namespace App\Application\Wallet\DTO;

use App\Domain\DTO\CreateDTOInterface;
use App\Domain\Entity\User;
use App\Domain\Enums\Currencies;

final class CreateWalletDTO implements CreateDTOInterface
{
    public readonly User $user;
    public readonly Currencies $currency;
    public readonly float $cash;

    public function __construct(
        User $user,
        Currencies $currency,
        float $cash
    )
    {
        $this->user = $user;
        $this->currency = $currency;
        $this->cash = $cash;
    }
}