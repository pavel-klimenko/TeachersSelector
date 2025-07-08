<?php declare(strict_types=1);

namespace App\Application\Teacher\DTO;

use App\Domain\Entity\CV;
use App\Domain\Entity\User;
use Doctrine\ORM\PersistentCollection;

final class ResponseTeacherDTO
{
    public readonly int $id;
    public readonly int $rating;
    public readonly PersistentCollection $hasTeacherExpertises;
    public readonly CV $cv;
    public readonly User $related_user;
    public readonly PersistentCollection $studying_modes;
    public readonly PersistentCollection $payment_types;


    public function __construct(
        int $id,
        int $rating,
        CV $cv,
        PersistentCollection $hasTeacherExpertises,
        User $related_user,
        PersistentCollection $studying_modes,
        PersistentCollection $payment_types,
    )
    {
        $this->id = $id;
        $this->rating = $rating;
        $this->cv = $cv;
        $this->hasTeacherExpertises = $hasTeacherExpertises;
        $this->related_user = $related_user;
        $this->studying_modes = $studying_modes;
        $this->payment_types = $payment_types;
    }
}