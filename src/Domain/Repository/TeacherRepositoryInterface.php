<?php declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Teacher;

interface TeacherRepositoryInterface
{
    public function save(Teacher $teacher): void;
    public function getList(): array;
    public function findTeachersByFilter(array $arFilter = []): array;
    public function getTeacher(int $id): object|null;
}