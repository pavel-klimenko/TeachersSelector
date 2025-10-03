<?php

namespace App\Application\Chats\PersonalChat\Command;

use App\Domain\Bus\Command\Command;
use App\Domain\Entity\Student;
use App\Domain\Entity\Teacher;


final class CreateChatCommand implements Command
{
    public function __construct(
        private readonly Student $student,
        private readonly Teacher $teacher,
    ) {
    }

   public function student(): Student
   {
       return $this->student;
   }

    public function teacher(): Teacher
    {
        return $this->teacher;
    }

}