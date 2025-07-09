<?php declare(strict_types=1);

namespace App\Application\User\DTO;

use App\Domain\Entity\City;

final class ResponseUserDTO
{
    public readonly int $id;
    public readonly City $city;
    public readonly string $email;
    public readonly array $arRoles;
    public readonly string $password;
    public readonly int $age;
    public readonly string $gender;
    public readonly string $name;


    public function __construct(
        int $id,
        City $city,
        string $email,
        array $arRoles,
        string $password,
        int $age,
        string $gender,
        string $name,
    )
    {
        $this->id = $id;
        $this->city = $city;
        $this->email = $email;
        $this->arRoles = $arRoles;
        $this->password = $password;
        $this->age = $age;
        $this->gender = $gender;
        $this->name = $name;
    }
}