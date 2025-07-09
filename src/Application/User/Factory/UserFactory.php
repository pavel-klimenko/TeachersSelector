<?php

namespace App\Application\User\Factory;

use App\Application\User\DTO\CreateUserDTO;
use App\Domain\Entity\User;

use App\Domain\ValueObject\User\Age;
use App\Domain\ValueObject\User\Email;
use App\Domain\ValueObject\User\Name;
use App\Domain\ValueObject\User\Password;
use App\Domain\ValueObject\User\Roles;

class UserFactory
{
    public static function makeObject(CreateUserDTO $DTO): User
    {
        $name = new Name($DTO->name);
        $email = new Email($DTO->email);
        $age = new Age($DTO->age);
        $roles = new Roles($DTO->arRoles);
        $password = new Password($DTO->password);

        $user = new User();
        $user
            ->setName($name->getName())
            ->setEmail($email->getEmail())
            ->setAge($age->getAge())
            ->setCity($DTO->city)
            ->setGender($DTO->gender)
            ->setRoles($roles->getRoles())
            ->setPassword($password->getPassword());

        return $user;
    }
}