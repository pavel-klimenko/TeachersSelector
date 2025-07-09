<?php declare(strict_types=1);

namespace App\Application\User\UseCase;

use App\Domain\Entity\User;

class CurrentUserRoles
{
    public static function execute(User $user):array
    {
        return $user->getRoles();
    }
}