<?php declare(strict_types=1);

namespace App\Application\User\UseCase;

use App\Application\User\DTO\CreateUserDTO;
use App\Application\User\Factory\UserFactory;
use App\Domain\Repository\UserRepositoryInterface;

class CreateUser
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ){}

    public function execute(CreateUserDTO $DTO):void
    {
        $newUser = UserFactory::makeObject($DTO);
        $this->userRepository->save($newUser);
    }
}