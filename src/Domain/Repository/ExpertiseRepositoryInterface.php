<?php declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Expertise;

interface ExpertiseRepositoryInterface
{
    public function getList(): array;
    public function save(Expertise $expertise): void;
}