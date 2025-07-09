<?php declare(strict_types=1);

namespace App\Application\Teacher\UseCase;

use App\Application\User\DTO\CreateUserDTO;
use App\Application\User\Factory\UserFactory;
use App\Domain\Repository\TeacherRepositoryInterface;
use App\Domain\Repository\UserRepositoryInterface;

class CreateTeacher
{
    public function __construct(
        private TeacherRepositoryInterface $teacherRepository,
    ){}


    public function execute(CreateUserDTO $DTO):void
    {
        $newUser = UserFactory::makeObject($DTO);
        $this->userRepository->save($newUser);
    }
}