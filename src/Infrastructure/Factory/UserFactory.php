<?php

namespace App\Infrastructure\Factory;

use App\Domain\Entity\User;
use App\Domain\Enums\Genders;
use App\Domain\Enums\UserRoles;
use App\Infrastructure\Repository\CityRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<User>
 */
final class UserFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct(
        private UserPasswordHasherInterface $userPasswordHasher,
        private CityRepository $cityRepository
    )
    {}

    public static function class(): string
    {
        return User::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        //TODO different cities (Random order)
        $minskCity = $this->cityRepository->findOneBy(['code' => 'minsk']);

        return [
            'city' => $minskCity, //TODO random cities
            'email' => self::faker()->email(),
            'isVerified' => true,
            'password' => $this->userPasswordHasher->hashPassword((new User()), 'almaz'),
            'roles' => [UserRoles::ROLE_USER->name],
            'name' => self::faker()->name(),
            'age' => self::faker()->numberBetween(25, 60),
            'gender' =>  Genders::MALE,
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(User $user): void {})
        ;
    }
}
