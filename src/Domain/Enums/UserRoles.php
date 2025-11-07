<?php

namespace App\Domain\Enums;

enum UserRoles: string
{
    case ROLE_USER = 'user';
    case ROLE_TEACHER = 'teacher';
    case ROLE_STUDENT = 'student';
}