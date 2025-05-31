<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
// use App\Card\DeckOfCard;
use App\Card\GameHelp;

class GameController extends AbstractController
{
    // startsida för kortspel
    #[Route("/game", name: "game")]
    public function game(

    ): Response {

        return $this->render('game/game.html.twig');
    }

    #[Route("/game/init", name: "gameInit")]
    //framsidan för spelet, starta genom att trycka på knapp
    public function gameInit(
        SessionInterface $session
    ): Response {

        $helper = new GameHelp();
        $helper->startGame($session);

        $data = [
            "userpoints" => $session->get("userpoints"),
            "bankpoints" => $session->get("bankpoints"),
            "cardhand" => $session->get("cardhand")
        ];

        return $this->render('game/game_init.html.twig', $data);

    }

    #[Route("/game/play", name: "game_play", methods: ["GET"])]
    public function playGet(): Response
    {
        return $this->render("game/game_play.html.twig");
    }

    #[Route("/game/play", name: "game_play", methods: ['POST'])]
    public function playPost(
        SessionInterface $session
    ): Response {
        $helper = new GameHelp();
        $helper->userPlay($session);

        $data = [
            "userpoints" => $session->get("userpoints"),
            "bankpoints" => $session->get("bankpoints"),
            "cardhand" => $session->get("cardhand")
        ];

        return $this->render('game/game_play.html.twig', $data);
    }

    #[Route("/game/save", name: "game_save", methods: ['POST'])]
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

        return $this->render('game/game_bank.html.twig', $data);
    }

    #[Route("/game/score", name: "game_score", methods: ['POST'])]
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

        return $this->render('game/game_score.html.twig', $data);
    }

    #[Route("/game/doc", name: "gameDoc")]
    public function gameDoc(

    ): Response {

        return $this->render('game/game_doc.html.twig');
    }
}
