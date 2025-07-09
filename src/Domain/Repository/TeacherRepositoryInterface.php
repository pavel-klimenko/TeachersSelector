<?php declare(strict_types=1);

namespace App\Domain\Repository;

use App\Application\Teacher\DTO\ResponseTeacherDTO;

interface TeacherRepositoryInterface
{
    public function getList(): array;

    public function findTeachersByFilter(array $arFilter = []): array;

    public function getTeacher(int $id): object|null;
}