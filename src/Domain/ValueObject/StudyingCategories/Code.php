<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\StudyingCategories;
final class Code
{
    public function __construct(
        private string $code,
    )
    {
        $this->assertCodeIsValid($code);
    }

    private function assertCodeIsValid($input) {
        if (!preg_match('/^[a-zA-Z0-9]+$/', $input)) {
            throw new \InvalidArgumentException('Code is invalid');
        }
    }
}
