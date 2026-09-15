<?php

namespace App\Factory;

use App\Entity\Genre;
use App\Repository\GenreRepository;
use Doctrine\ORM\EntityRepository;
use Zenstruck\Foundry\Persistence\PersistentObjectFactory;
use Zenstruck\Foundry\Persistence\Proxy;
use Zenstruck\Foundry\Persistence\ProxyRepositoryDecorator;

/**
 * @extends PersistentObjectFactory<Genre>
 */
final class GenreFactory extends PersistentObjectFactory
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
        return Genre::class;
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#model-factories
     *
     * @todo add your default values here
     */
    #[\Override]
    protected function defaults(): array|callable
    {
        $genreColors = [
            'rock' => '#E74C3C',
            'reggae' => '#E67E22',
            'classique' => '#F1C40F',
            'jazz' => '#2ECC71',
            'pop' => '#1ABC9C',
            'hip-hop' => '#3498DB',
            'electro' => '#9B59B6',
            'blues' => '#34495E',
            'metal' => '#F39C12',
            'funk' => '#D35400',
            'soul' => '#C0392B',
            'country' => '#16A085',
            'folk' => '#27AE60',
            'punk' => '#2980B9',
            'disco' => '#8E44AD',
            'rnb' => '#2C3E50',
            'rap' => '#EC7063',
            'house' => '#5DADE2',
            'techno' => '#48C9B0',
            'ambient' => '#F4D03F',
        ];

        $name = self::faker()->unique()->randomElement(array_keys($genreColors));

        return [
            'color' => $genreColors[$name],
            'createdAt' => \DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'name' => $name,
        ];
    }

    /**
     * @see https://symfony.com/bundles/ZenstruckFoundryBundle/current/index.html#initialization
     */
    #[\Override]
    protected function initialize(): static
    {
        return $this
            // ->afterInstantiate(function(Genre $genre): void {})
        ;
    }
}
