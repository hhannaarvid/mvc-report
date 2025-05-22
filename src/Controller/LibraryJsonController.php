<?php

namespace App\Controller;

// use App\Card\PrettyDeck;
// use App\Card\CardHand;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
// use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Repository\LibraryRepository;

class LibraryJsonController extends AbstractController
{
    #[Route('api/library/books', name: 'library_books')]
    public function libraryBooks(
        LibraryRepository $libraryRepository
    ): Response {
        $library = $libraryRepository->findAll();
        return $this->json($library);
    }

    #[Route('api/library/book/{isbn}', name: 'library_books_one')]
    public function libraryBook(
        LibraryRepository $libraryRepository,
        int $isbn
    ): Response {
        $library = $libraryRepository->findOneBy(['ISBN' => $isbn]);

        if (!$library) {
            return $this->json(['error' => 'Book not found'], 404);
        }


        return $this->json($library);
    }
}