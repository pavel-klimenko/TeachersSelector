<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\Teacher;
final class YearsExperience
{
    private const MIN_YEAR_EXPERIENCE = 0;
    private const MAX_YEAR_EXPERIENCE = 80;

    public function __construct(
        private int $years,
    ) {
        $this->assertIsValid($years);
    }

    public function getYears():int
    {
        return $this->years;
    }

    private function assertIsValid(int $value):void
    {
        if (self::MIN_YEAR_EXPERIENCE < 0 || $value > self::MAX_YEAR_EXPERIENCE) {
            throw new \InvalidArgumentException('Year of experience is invalid');
        }
    }
}
