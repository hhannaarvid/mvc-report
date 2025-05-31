<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Card\DeckOfCard;
use App\Card\GameHelp;
use Symfony\Component\HttpFoundation\RedirectResponse;

class ProjectController extends AbstractController
{
    // STARTSIDA FÖR SPELET #################################
    #[Route("/proj", name: "proj")]
    public function home(): Response
    {
        return $this->render('project/proj.html.twig');
    }


    // INFORMATION OM PROJEKT #################################
    #[Route("/proj/about", name: "proj_about")]
    public function homeAbout(): Response
    {
        return $this->render('project/proj_about.html.twig');
    }


    // SPARA NAMN #################################
    #[Route("/name_post", name: "name_post", methods: ['POST'])]
    public function saveName(Request $request, SessionInterface $session): RedirectResponse
    {
        $userOne = $request->request->get('user-one');
        $userTwo = $request->request->get('user-two');
        $userThree = $request->request->get('user-three');
        $players = 0;

        if ($userOne) {
            $session->set('user_one', $userOne);
            $session->set('user_one_points', 0);
            $players += 1;
        }

        if ($userTwo) {
            $session->set('user_two', $userTwo);
            $session->set('user_two_points', 0);
            $players += 1;

        }

        if ($userThree) {
            $session->set('user_three', $userThree);
            $session->set('user_three_points', 0);
            $players += 1;

        }

        $session->set('players', $players);

        return $this->redirectToRoute('projInit');
    }


    // INITIERA SPELET #################################
    #[Route("/proj/init", name: "projInit")]
    public function gameInit(
        SessionInterface $session
    ): Response {

        $helper = new GameHelp();
        $helper->startGame($session);

        $data = [
            "userpoints" => $session->get("userpoints"),
            "bankpoints" => $session->get("bankpoints"),
            "cardhand" => $session->get("cardhand"),
            "userOne" => $session->get("user_one")
        ];

        return $this->render('project/proj_init.html.twig', $data);
    }


    // DRA ETT KORT #################################
    #[Route("/proj/play", name: "proj_play", methods: ["GET"])]
    public function playGet(): Response
    {
        return $this->render("proj/proj_play.html.twig");
    }


    // DRA ETT KORT #################################
    #[Route("/proj/play", name: "proj_play", methods: ['POST'])]
    public function playPost(
        SessionInterface $session
    ): Response {
        $helper = new GameHelp();
        $helper->userPlay($session);

        $data = [
            "userpoints" => $session->get("userpoints"),
            "bankpoints" => $session->get("bankpoints"),
            "cardhand" => $session->get("cardhand"),
            "userOne" => $session->get("user_one")
        ];

        return $this->render('project/proj_play.html.twig', $data);
    }

    #[Route("/proj/save", name: "proj_save", methods: ['POST'])]
    public function save(
        SessionInterface $session
    ): Response {
        $helper = new GameHelp();

        $helper->bank($session);


        $data = [
            "userpoints" => $session->get("userpoints"),
            "bankpoints" => $session->get("bankpoints"),
            "cardhand" => $session->get("cardhand"),
            "bankhand" => $session->get("bankhand")
        ];

        return $this->render('project/proj_bank.html.twig', $data);
    }

    #[Route("/proj/score", name: "proj_score", methods: ['POST'])]
    public function score(
        SessionInterface $session
    ): Response {

        $helper = new GameHelp();
        $message = $helper->score($session);
        $data = [
            "userpoints" => $session->get("userpoints"),
            "bankpoints" => $session->get("bankpoints"),
            "message" => $message
        ];

        return $this->render('project/proj_score.html.twig', $data);
    }
}
