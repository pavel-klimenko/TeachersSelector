<?php declare(strict_types=1);

namespace App\Application\Student\UseCase;

use App\Domain\Repository\StudentRepositoryInterface;

class GetAmount
{
    public function __construct(
        private StudentRepositoryInterface $studentRepository,
    ){}

    public function execute():int
    {
        return $this->studentRepository->getAmount();
    }
}