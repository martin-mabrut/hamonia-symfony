<?php

namespace App\Controller;

use App\Repository\AlbumRepository;
use App\Repository\TrackRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
}
