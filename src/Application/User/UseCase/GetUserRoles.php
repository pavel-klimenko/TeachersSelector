<?php declare(strict_types=1);

namespace App\Application\User\UseCase;

use App\Domain\Enums\UserRoles;

class GetUserRoles
{
    public static function executeAll():array
    {
        return [
            UserRoles::ROLE_USER->name,
            UserRoles::ROLE_TEACHER->name,
            UserRoles::ROLE_STUDENT->name
        ];
    }

    public static function executeForTeacher():array
    {
        return [
            UserRoles::ROLE_USER->name,
            UserRoles::ROLE_TEACHER->name,
        ];
    }

    public static function executeForStudent():array
    {
        return [
            UserRoles::ROLE_USER->name,
            UserRoles::ROLE_STUDENT->name,
        ];
    }

    public static function getTeacherRole():string
    {
        return UserRoles::ROLE_TEACHER->name;
    }

    public static function getStudentRole():string
    {
        return UserRoles::ROLE_STUDENT->name;
    }
}