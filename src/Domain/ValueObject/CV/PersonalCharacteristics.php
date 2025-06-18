<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\CV;
final class PersonalCharacteristics
{
    public function __construct(
        private string $body,
    ){}
}