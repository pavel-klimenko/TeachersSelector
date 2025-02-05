<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\Teacher;

final class Salary
{
    public function __construct(private float $salary)
    {
        $this->assertSalaryIsValid($salary);
    }

    public function getSalary():float
    {
        return $this->salary;
    }

    private function assertSalaryIsValid(float $value):void
    {
        if ($value <= 0) {
            throw new \InvalidArgumentException('Invalid salary');
        }
    }
}
