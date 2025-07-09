<?php declare(strict_types=1);

namespace App\Domain\Repository;

interface ExpertiseRepositoryInterface
{
    public function getList(): array;
}