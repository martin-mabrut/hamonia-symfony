<?php

namespace App\Controller;

use App\Entity\Album;
use App\Repository\AlbumRepository;
use Doctrine\ORM\EntityManagerInterface;
use App\Form\AlbumType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

final class AlbumController extends AbstractController
{
    #[Route('/album/{id}', name: 'app_album_item')]
    public function item($id, AlbumRepository $albumRepository): Response
    {
        $album = $albumRepository->find($id);
        if($id === null || $album === null) {
            return $this->redirectToRoute('app_home');
        }
        dump($album);

        return $this->render('album/index.html.twig', [
            'album' => $album,
        ]);
    }

    #[Route('/add-album', name: 'app_add_album')]
    public function addAlbum(AlbumRepository $albumRepository, EntityManagerInterface $entityManager, Request $request, SluggerInterface $slugger, #[Autowire('%kernel.project_dir%/public/uploads')] string $pochettesDirectory): Response
    {
        $album = new Album();
        $form = $this->createForm(AlbumType::class, $album);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $album->setCreatedAt(new \DateTimeImmutable());

            $pochetteFile = $form->get('pochette')->getData();

            if ($pochetteFile) {
                $originalFilename = pathinfo($pochetteFile->getClientOriginalName(), PATHINFO_FILENAME);

                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$pochetteFile->guessExtension();
                try {
                    $pochetteFile->move($pochettesDirectory, $newFilename);
                } catch (FileException $e) {
                }

                $album->setCover("uploads/" . $newFilename);
            }

            $entityManager->persist($album);
            $entityManager->flush();

            $newAlbum = $albumRepository->findOneBy(['createdAt' => $album->getCreatedAt()]);

            return $this->redirectToRoute('app_album_item', ['id' => $newAlbum->getId()]);
        }

        return $this->render('album/add.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
