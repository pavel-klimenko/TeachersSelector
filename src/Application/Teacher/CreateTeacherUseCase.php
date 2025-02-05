<?php

declare(strict_types=1);

namespace App\Application\Teacher;

use App\Domain\Entity\Worker;
use App\Domain\Repository\WorkerRepositoryInterface;
use App\Domain\ValueObject\Teacher\Age;
use App\Domain\ValueObject\Teacher\Gender;
use App\Domain\ValueObject\Teacher\Name;
use App\Domain\ValueObject\Teacher\Salary;

class CreateTeacherUseCase
{
    public function __construct(
        private WorkerRepositoryInterface $workerRepository
    ){}

    public function execute()
    {
        $worker = new Worker(
          new Age(24),
          new Gender('MALE'),
          new Name('Pavel', 'Klimenko', 'Alexandrovich'),
          new Salary(2400),
        );

        $this->workerRepository->add($worker);
    }

}
