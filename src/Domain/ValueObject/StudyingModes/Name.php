<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\StudyingModes;
final class Name
{
    public function __construct(
        private string $name,
    )
    {
        $this->assertNameIsValid($name);
    }

    private function assertNameIsValid($input) {
        if (!preg_match('/^[a-zA-Zа-яА-ЯёЁ0-9]+$/u', $input)) {
            throw new \InvalidArgumentException('Name is invalid');
        }
    }
}
