<?php declare(strict_types=1);

namespace App\Application\StudyingMode\DTO;

final class CreateStudyingModeDTO
{
    public readonly string $name;
    public readonly string $code;
    public function __construct(
        string $name,
        string $code,
    )
    {
        $this->name = $name;
        $this->code = $code;
    }
}