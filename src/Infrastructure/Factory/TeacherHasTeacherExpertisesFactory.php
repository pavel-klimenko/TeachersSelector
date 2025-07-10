<?php

namespace App\Infrastructure\Factory;

use App\Domain\Entity\TeacherHasTeacherExpertises;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<TeacherHasTeacherExpertises>
 */
final class TeacherHasTeacherExpertisesFactory extends PersistentProxyObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    public static function class(): string
    {
        return TeacherHasTeacherExpertises::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'rating' => self::faker()->numberBetween(1, 5),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(TeacherHasTeacherExpertises $teacherHasTeacherExpertises): void {})
        ;
    }
}
