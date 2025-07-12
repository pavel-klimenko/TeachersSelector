<?php declare(strict_types=1);

namespace App\Application\Student\UseCase;

class GetTestStudentEmail
{
    public static function execute():string
    {
        return 'test_user_student@mail.com';
    }
}