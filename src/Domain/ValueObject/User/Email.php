<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\User;
final class Email
{
    public function __construct(
        private string $email,
    )
    {
        $this->assertEmailIsValid($email);
    }

    public function getEmail():string
    {
        return $this->email;
    }

    private function assertEmailIsValid(string $email):void
    {
        if (!preg_match('/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/', $email)) {
            throw new \InvalidArgumentException('Email is invalid');
        }
    }
}
