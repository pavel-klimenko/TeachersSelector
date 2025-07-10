<?php declare(strict_types=1);

namespace App\Application\User\UseCase;

use App\Application\User\DTO\CreateUserDTO;
use App\Application\User\Factory\UserFactory;
use App\Domain\Entity\User;
use App\Domain\Repository\UserRepositoryInterface;

class CreateUser
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
    ){}

    public function execute(CreateUserDTO $DTO):User
    {
        $newUser = UserFactory::makeObject($DTO);
        return $this->userRepository->save($newUser);
    }
}