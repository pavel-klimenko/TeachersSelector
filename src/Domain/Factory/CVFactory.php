<?php

namespace App\Domain\Factory;

use App\Domain\Entity\CV;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<CV>
 */
final class CVFactory extends PersistentProxyObjectFactory
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
        return CV::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    protected function defaults(): array|callable
    {
        return [
            'experience' => self::faker()->text(),
            'years_of_experience' => self::faker()->numberBetween(3, 6),
            'personal_characteristics' => self::faker()->text(),
            'rate_per_hour' => round(self::faker()->randomFloat(null, 10, 30)),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(CV $cV): void {})
        ;
    }
}
