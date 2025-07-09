<?php

declare(strict_types=1);

namespace App\Domain\ValueObject\User;

use App\Domain\Enums\UserRoles;

final class Roles
{
    public function __construct(private array $arRoles)
    {
        $this->assertRolesValid($arRoles);
    }

    public function getRoles():array
    {
        return $this->arRoles;
    }

    private function assertRolesValid(array $arRoles):void
    {
        $arAvailableRoles = [];
        foreach (UserRoles::cases() as $role) {
            $arAvailableRoles[] = $role->name;
        }

        foreach ($arRoles as $role) {
            if (!in_array($role, $arAvailableRoles)) {
                throw new \InvalidArgumentException("Wrong role name ".$role);
            }
        }
    }
}
