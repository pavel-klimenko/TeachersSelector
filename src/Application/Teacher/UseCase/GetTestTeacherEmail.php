<?php declare(strict_types=1);

namespace App\Application\Teacher\UseCase;

class GetTestTeacherEmail
{
    public static function execute():string
    {
        return 'test_user_teacher@mail.com';
    }
}