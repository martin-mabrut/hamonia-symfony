<?php

namespace App\Controller;

use App\Entity\Artiste;
use App\Form\ArtistType;
use App\Repository\ArtisteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ArtistController extends AbstractController
{
    #[Route('/artist', name: 'app_artist')]
    public function index(ArtisteRepository $artisteRepository): Response
    {

        $artists = $artisteRepository->findAll();

        return $this->render('artist/index.html.twig', [
            'artists' => $artists,
        ]);
    }

    #[Route('/artist-create', name: 'app_artist_create')]
    public function addArtist(EntityManagerInterface $entityManager, Request $request): Response
    {
        $artist = new Artiste();

        $form = $this->createForm(ArtistType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $artist->setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($artist);
            $entityManager->flush();
        }

        return $this->render('artist/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
