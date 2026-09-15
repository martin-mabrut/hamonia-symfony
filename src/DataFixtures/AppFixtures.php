<?php

namespace App\DataFixtures;

use App\Factory\AlbumFactory;
use App\Factory\ArtisteFactory;
use App\Factory\CountryFactory;
use App\Factory\FavoriteFactory;
use App\Factory\GenreFactory;
use App\Factory\PlaylistFactory;
use App\Factory\StreamFactory;
use App\Factory\TrackFactory;
use App\Factory\UserFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        CountryFactory::createMany(20);

        ArtisteFactory::createMany(50);

        AlbumFactory::createMany(50);

        GenreFactory::createMany(20);

        UserFactory::createMany(50);

        TrackFactory::createMany(200);

        PlaylistFactory::createMany(30);

        FavoriteFactory::createMany(45);

        StreamFactory::createMany(200);

        $manager->flush();
    }
}
