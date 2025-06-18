<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\CV;
final class RatePerHour
{
    private CONST MAX_RATE = 150;
    private CONST MIN_RATE = 10;

    public function __construct(
        private float $rate,
    )
    {
        $this->assertRateIsValid($rate);
    }

    private function assertRateIsValid($rate) {
        if ($rate < self::MIN_RATE || $rate > self::MAX_RATE) {
            throw new \InvalidArgumentException('Rate is out of the range');
        }
    }
}