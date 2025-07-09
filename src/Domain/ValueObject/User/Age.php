<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\User;

use App\Domain\Entity\User;

final class Age
{
    public function __construct(private int $age)
    {
        $this->assertAgeIsValid($age);
    }

    public function getAge():int
    {
        return $this->age;
    }

    private function assertAgeIsValid(int $age):void
    {
        if ($age < User::MIN_AGE || $age > User::MAX_AGE) {
            throw new \InvalidArgumentException("User age must be in range: ".User::MIN_AGE." - ".User::MAX_AGE);
        }
    }
}
