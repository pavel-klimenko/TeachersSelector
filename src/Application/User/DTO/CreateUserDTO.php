<?php declare(strict_types=1);

namespace App\Application\User\DTO;

use App\Domain\Entity\City;
use App\Domain\Enums\Genders;

final class CreateUserDTO
{
    public readonly City $city;
    public readonly string $email;
    public readonly array $arRoles;
    public readonly string $password;
    public readonly int $age;
    public readonly Genders $gender;
    public readonly string $name;


    public function __construct(
        City $city,
        string $email,
        array $arRoles,
        string $password,
        int $age,
        Genders $gender,
        string $name,
    )
    {
        $this->city = $city;
        $this->email = $email;
        $this->arRoles = $arRoles;
        $this->password = $password;
        $this->age = $age;
        $this->gender = $gender;
        $this->name = $name;
    }
}