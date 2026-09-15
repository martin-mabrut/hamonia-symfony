<?php

namespace App\Factory;

use App\Entity\Country;
use App\Repository\CountryRepository;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentObjectFactory<Country>
 */
final class CountryFactory extends PersistentObjectFactory
{
    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#factories-as-services
     *
     * @todo inject services if required
     */
    public function __construct()
    {
    }

    #[\Override]
    public static function class(): string
    {
        return Country::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    #[\Override]
    protected function defaults(): array|callable
    {
        $countries = [
            'France', 'Belgique', 'Suisse', 'Canada', 'Etats-Unis',
            'Royaume-Uni', 'Allemagne', 'Espagne', 'Italie', 'Portugal',
            'Pays-Bas', 'Suede', 'Norvege', 'Danemark', 'Pologne',
            'Bresil', 'Japon', 'Coree du Sud', 'Australie', 'Maroc',
        ];

        return [
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'name' => self::faker()->unique()->randomElement($countries),
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    #[\Override]
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Country $country): void {})
        ;
    }
}
