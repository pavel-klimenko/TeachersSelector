<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Teacher\Age;
use App\Domain\ValueObject\Teacher\Gender;
use App\Domain\ValueObject\Teacher\Name;
use App\Domain\ValueObject\Teacher\Salary;

final class Teacher
{
     public function __construct(
         private Age $age,
         private Gender $gender,
         private Name $name,
         private Salary $salary,
     ){}

    public function getAge():Age
    {
        return $this->age;
    }

    public function getGender():Gender
    {
        return $this->gender;
    }

    public function getName():Name
    {
        return $this->name;
    }

    public function getSalary():Salary
    {
        return $this->salary;
    }

}
