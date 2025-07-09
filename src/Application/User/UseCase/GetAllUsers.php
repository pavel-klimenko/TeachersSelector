<?php declare(strict_types=1);

namespace App\Application\User\UseCase;

use App\Domain\Repository\UserRepositoryInterface;

class GetAllUsers
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ){}


    //TODO can add user`s DTO

    public function executeEntities():array
    {
        return $this->userRepository->getList();
    }
}