<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Teacher;
use App\Domain\Repository\TeacherRepositoryInterface;

class TeacherRepository implements TeacherRepositoryInterface
{
    public function add(Teacher $teacher):void
    {

        dd($teacher);

        //todo made the method
    }

    public function remove(Teacher $teacher):void
    {
        //todo made the method
    }

    public function getById(int $id):Teacher
    {
        //todo made the method
    }

//    public function getPrevById():\Worker;
//    public function getNextById():\Worker;
}
