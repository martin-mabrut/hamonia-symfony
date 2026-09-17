<?php

namespace App\Controller;

use App\Entity\Track;
use App\Form\TrackType;
use App\Repository\AlbumRepository;
use App\Repository\TrackRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TrackController extends AbstractController
{
    #[Route('/track/{id}', name: 'app_track_item')]
    public function index($id, TrackRepository $trackRepository): Response
    {
        $track = $trackRepository->find($id);
        if($id === null){
            return $this->redirectToRoute('app_home');
        }
        dump($track);

        return $this->render('track/index.html.twig', [
            'track' => $track,
        ]);
    }

    #[Route('/add-track/{id}', name: 'app_add_track')]
    public function addTrack($id, AlbumRepository $albumRepository, EntityManagerInterface $entityManager, Request $request): Response
    {
        $album = $albumRepository->find($id);

        $track = new Track();
        //album

        $tracks = $album->getTracks();

        $form = $this->createForm(TrackType::class, $track);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $track->setCreatedAt(new \DateTimeImmutable());
            $track->setTrackNumber(count($tracks)+1);
            $track->setAlbums($album);
            $track->setDuration(rand(60, 350));

            $entityManager->persist($track);
            $entityManager->flush();

            return $this->redirectToRoute('app_album_item', ['id' => $id]);
        }

        return $this->render('track/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
