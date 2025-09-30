<?php

namespace App\Application\Payment\Command;

use App\Domain\Bus\Command\Command;
use App\Domain\Entity\User;

final class MakePaymentCommand implements Command
{
    public function __construct(
        private readonly User $sourceUser,
        private readonly User $targetUser,
        private readonly float $sum,
    ) {
    }

   public function sourceUser(): User
   {
       return $this->sourceUser;
   }

    public function targetUser(): User
    {
        return $this->targetUser;
    }

   public function sum(): float
   {
       return $this->sum;
   }

}