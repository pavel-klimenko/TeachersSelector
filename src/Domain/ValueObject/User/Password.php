<?php declare(strict_types=1);

namespace App\Domain\ValueObject\User;

final class Password
{
    public function __construct(
        private string $password,
    ){}

    public function getPassword():string
    {
        return $this->password;
    }
}
