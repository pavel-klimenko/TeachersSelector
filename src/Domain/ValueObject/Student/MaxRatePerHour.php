<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\Student;

final class MaxRatePerHour
{
    private const MIN_RATE = 0;
    private const MAX_RATE = 250;

    public function __construct(
        private float $rate,
    ) {
        $this->assertIsValid($rate);
    }

    public function getRate():float
    {
        return $this->rate;
    }

    private function assertIsValid(float $value):void
    {
        if (self::MIN_RATE < 0 || $value > self::MAX_RATE) {
            throw new \InvalidArgumentException('Rate is out of the range');
        }
    }
}
