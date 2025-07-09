<?php declare(strict_types=1);

namespace App\Application\Teacher\DTO;

use App\Domain\Entity\User;

final class CreateTeacherDTO
{
    public readonly User $relatedUser;
    public readonly int $rating;

    public function __construct(
        User $relatedUser,
        int $rating,
    )
    {
        $this->relatedUser = $relatedUser;
        $this->rating = $rating;
    }
}