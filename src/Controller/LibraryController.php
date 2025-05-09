<?php

namespace App\Controller;

use App\Repository\LibraryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LibraryController extends AbstractController
{
    #[Route('/library', name: 'app_library')]
    public function index(): Response
    {
        return $this->render('library/index.html.twig', [
            'controller_name' => 'LibraryController',
        ]);
    }

    #[Route('/library/view', name: 'library_view')]
    public function libraryView(
        LibraryRepository $libraryRepository
    ): Response
    {
        $library = $libraryRepository->findAll();

        $data = [
            'library' => $library
        ];

        return $this->render('library/library_view.html.twig', $data);
    }
}
