<?php declare(strict_types=1);

namespace App\Domain\ValueObject\Expertise;

final class Code
{
    public function __construct(
        private string $code,
    ){}

    public function getCode(): string
    {
        return $this->code;
    }
}