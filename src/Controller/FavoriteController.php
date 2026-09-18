<?php

namespace App\Controller;

use App\Entity\Favorite;
use App\Repository\FavoriteRepository;
use App\Repository\TrackRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class FavoriteController extends AbstractController
{
    #[Route('/toggle-favorite/{id}', name: 'app_toggle_favorite')]
    public function addFavorite($id, TrackRepository $trackRepository, EntityManagerInterface $entityManager, FavoriteRepository $favoriteRepository): Response
    {
        $track = $trackRepository->find($id);
        $user = $this->getUser();

        $existingFavorite = $favoriteRepository->findOneBy([
            'track' => $track,
            'user' => $this->getUser(),
        ]);

        if ($existingFavorite === null) {

            $favorite = new Favorite();
            $favorite->setUser($user);
            $favorite->setTrack($track);
            $favorite->setCreatedAt(new \DateTimeImmutable());
            $entityManager->persist($favorite);
            $entityManager->flush();

            return $this->json(['status du morceau'=> 'en favoris']);

        } else {
            $entityManager->remove($existingFavorite);
            $entityManager->flush();

            return $this->json(['status du morceau'=> 'pas en favoris']);
        }

//        return $this->redirectToRoute('app_track_item', ['id' => $id]);

    }
}
