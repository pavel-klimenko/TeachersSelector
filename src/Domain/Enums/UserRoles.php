<?php

namespace App\Domain\Enums;

enum UserRoles: string
{
    case ROLE_USER = 'User';
    case ROLE_TEACHER = 'Teacher';
    case ROLE_STUDENT = 'Student';
}