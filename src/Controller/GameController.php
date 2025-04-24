<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Card\Card;
use App\Card\DeckOfCard;
use App\Card\CardHand;

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
            Request $request,
            SessionInterface $session
        ): Response {

            //skapa rätt variabler i session
            $session->set("userpoints", 0);
            $session->set("draws", 0);
            $session->set("bankpoints", 0);
            $session->set("cardhand", []);


            //skapa ny kortlek
            $deck = new DeckOfCard();

            // blanda kortleken
            $deck->shuffle();

            //spara blandad kortlek (objekt) i session
            $session->set("gameDeck", $deck);

            $data = [
                "userpoints"=> $session->get("userpoints"),
                "bankpoints"=> $session->get("bankpoints"),
                "cardhand"=> $session->get("cardhand")
            ];

            return $this->render('game/game_init.html.twig', $data);
        
    }

    // #[Route("/game/init", name: "gameInit", methods: ["POST"])]
    // public function initCallback(): Response
    // {
    //     return $this->redirectToRoute("game_play");
    // }

    #[Route("/game/play", name: "game_play", methods: ["GET"])]
    public function Play(): Response
    {
        return $this->render("game/game_play.html.twig");
    }

    #[Route("/game/play", name: "game_play", methods: ['POST'])]
    public function roll(
        SessionInterface $session
    ): Response
    {
            $deck = $session->get("gameDeck");
            $cardhand = $session->get("cardhand");


            //dra ett kort
            $draw = $deck->draw();
            $cardhand[] = $draw->getCardString();
            $session->set("cardhand", $cardhand);

            //ta fram poäng för kortet
            $rank = $draw->getRank();
            $points = $session->get("userpoints");
            $total = $rank + $points;
            $session->set("userpoints", $total);

            $data = [
                "userpoints"=> $session->get("userpoints"),
                "bankpoints"=> $session->get("bankpoints"),
                "cardhand"=> $session->get("cardhand")
            ];

        return $this->render('game/game_play.html.twig', $data);
    }
}