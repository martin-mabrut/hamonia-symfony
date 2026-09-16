<?php

namespace App\Controller;

use App\Repository\PlaylistRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class PlaylistController extends AbstractController
{
    #[Route('/playlist/{id}', name: 'app_playlist_item')]
    public function index($id, PlaylistRepository $playlistRepository): Response
    {
        $playlist = $playlistRepository->find($id);
        if($id === null){
            return $this->redirectToRoute('app_home');
        }
        dump($playlist);
        return $this->render('playlist/index.html.twig', [
            'playlist' => $playlist,
        ]);
    }
}
