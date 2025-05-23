<?php

namespace App\Controller;

use App\Entity\Library;
use Doctrine\Persistence\ManagerRegistry;
use App\Repository\LibraryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
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
    ): Response {
        $library = $libraryRepository->findAll();

        $data = [
            'library' => $library
        ];

        return $this->render('library/library_view.html.twig', $data);
    }

    #[Route('/library/view/{id}', name: 'library_view_one')]
    public function showBookbyId(
        LibraryRepository $libraryRepository,
        int $id
    ): Response {
        $library = $libraryRepository
            ->find($id);

        $data = [
            'library' => $library
        ];


        return $this->render('library/library_view_one.html.twig', $data);
    }

    #[Route('/library/create', name: 'library_create', methods: ['GET'])]
    public function createLibrary(
    ): Response {

        return $this->render('library/library_create.html.twig');
    }

    #[Route('library/create', name: 'library_create_post', methods: ['POST'])]
    public function createPost(
        Request $request,
        ManagerRegistry $doctrine
    ): Response {
        $entityManager = $doctrine->getManager();
        $titel = (string) $request->request->get('i_titel');
        $isbn = (int) $request->request->get('i_isbn');
        $forfattare = (string) $request->request->get('i_forfattare');
        $bild = (string) $request->request->get('i_bild');
        $bildnamn = (string) $request->request->get('i_bildnamn');

        $library = new Library();
        $library->setTitel($titel);
        $library->setIsbn((int)$isbn);
        $library->setForfattare($forfattare);
        $library->setBildnamn($bildnamn);
        $library->setBild($bild);

        // tell Doctrine you want to (eventually) save the Product
        $entityManager->persist($library);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->redirectToRoute('library_view');
    }

    #[Route('/delete/delete/{id}', name: 'library_delete')]
    public function deleteBookById(
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $library = $entityManager->getRepository(Library::class)->find($id);

        if (!$library) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $entityManager->remove($library);
        $entityManager->flush();

        return $this->redirectToRoute('library_view');
    }

    #[Route('library/update/{id}', name: 'library_update', methods: ['GET'])]
    public function updateGet(
        LibraryRepository $libraryRepository,
        int $id
    ): Response {
        $library = $libraryRepository
            ->find($id);

        $data = [
            'library' => $library
        ];

        return $this->render('library/library_update.html.twig', $data);
    }

    #[Route('/library/update/{id}', name: 'library_update_post', methods: ['POST'])]
    public function updatePOST(
        Request $request,
        ManagerRegistry $doctrine,
        int $id
    ): Response {
        $entityManager = $doctrine->getManager();
        $library = $entityManager->getRepository(Library::class)->find($id);

        if (!$library) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $titel = (string) $request->request->get('i_titel');
        $isbn = (int) $request->request->get('i_isbn');
        $forfattare = (string) $request->request->get('i_forfattare');
        $bild = (string) $request->request->get('i_bild');
        $bildnamn = (string) $request->request->get('i_bildnamn');

        $library->setTitel($titel);
        $library->setIsbn((int)$isbn);
        $library->setForfattare($forfattare);
        $library->setBildnamn($bildnamn);
        $library->setBild($bild);

        // actually executes the queries (i.e. the INSERT query)
        $entityManager->flush();

        return $this->redirectToRoute('library_view');
    }
}
