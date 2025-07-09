<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\StudyingMode;
final class Code
{
    public function __construct(
        private string $code,
    )
    {}

    public function getCode():string
    {
        return $this->code;
    }

}
