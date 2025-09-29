<?php

namespace App\Application\Student\Command;

use App\Domain\Bus\Command\Command;
use App\Domain\Entity\User;

final class MakePaymentCommand implements Command
{
    public function __construct(
        private readonly User $user,
        private readonly string $sum,
    ) {
    }

   public function user(): User
   {
       return $this->user;
   }

   public function sum(): float
   {
       return $this->sum;
   }

}