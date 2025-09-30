<?php

namespace App\Application\Wallet\Factory;

use App\Application\Wallet\DTO\CreateWalletDTO;
use App\Domain\Entity\Wallet;

class WalletFactory
{
    public static function makeObject(CreateWalletDTO $DTO): Wallet
    {
        $payment = new Wallet();
        $payment
            ->setUser($DTO->user)
            ->setCurrency($DTO->currency)
            ->setCash($DTO->cash);

        return $payment;
    }
}