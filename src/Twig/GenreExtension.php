<?php

namespace App\Twig;

use App\Repository\GenreRepository;
use Twig\Attribute\AsTwigFilter;
use Twig\Attribute\AsTwigFunction;

final class GenreExtension
{
    private GenreRepository $genreRepository;
    public function __construct(GenreRepository $genreRepository)
    {
        $this->genreRepository = $genreRepository;
    }

    #[AsTwigFilter('filter_name')]
    public function doSomething(string $value): string
    {
        // ...

        return $value;
    }

    #[AsTwigFunction('getGenres')]
    public function getGenres()
    {
        return $this->genreRepository->findAll();
    }
}
