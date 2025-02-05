<?php

declare(strict_types=1);

namespace App\Domain\Repository;

use App\Domain\Entity\Teacher;

interface TeacherRepositoryInterface
{
    public function add(Teacher $teacher):void;
    public function remove(Teacher $teacher):void;
    public function getById(int $id):Teacher;

//    public function getPrevById():\Worker;
//    public function getNextById():\Worker;
}
