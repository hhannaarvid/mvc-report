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
            $session->set("bankhand", []);


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
    public function play_get(): Response
    {
        return $this->render("game/game_play.html.twig");
    }

    #[Route("/game/play", name: "game_play", methods: ['POST'])]
    public function play_post(
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

    #[Route("/game/save", name: "game_save", methods: ['POST'])]
    public function save(
        SessionInterface $session
    ): Response
    {
            //skapa ny kortlek
            $deck = new DeckOfCard();

            // blanda kortleken
            $deck->shuffle();

            //hur många kort ska banken dra
            $number = rand(1,3);

            //dra ett kort
            for ($i=1; $i<=$number; $i++) {
                $draw = $deck->draw();
                $bankhand[] = $draw->getCardString();
                //ta fram poäng för kortet
                $rank = $draw->getRank();
                $points = $session->get("bankpoints");
                $total = $rank + $points;
                $session->set("bankpoints", $total);
            }

            $session->set("bankhand", $bankhand);

            
            $data = [
                "userpoints"=> $session->get("userpoints"),
                "bankpoints"=> $session->get("bankpoints"),
                "cardhand"=> $session->get("cardhand"),
                "bankhand"=> $session->get("bankhand")
            ];

        return $this->render('game/game_bank.html.twig', $data);
    }

    
    #[Route("/game/score", name: "game_score", methods: ['POST'])]
    public function score(
        SessionInterface $session
    ): Response
    {
        $userpoints = $session->get("userpoints");
        $bankpoints = $session->get("bankpoints");
        $cardhand = $session->get("cardhand");
        $bankhand = $session->get("bankhand");
        $message = "";

        if ($userpoints > 21 && $bankpoints > 21) {
            $message = "Båda fick över 21, alltså vann ingen.";
        } elseif ($userpoints === $bankpoints) {
            $message = "Banken vann!";
        } elseif ($userpoints > 21 && $bankpoints <= 21){
            $message ="Banken vann!";
        } elseif ($bankpoints > 21 && $userpoints <= 21) {
            $message = "Du vann!";
        } elseif ($userpoints > $bankpoints && $userpoints <= 21) {
            $message = "Du vann!";
        } elseif ($userpoints < $bankpoints && $bankpoints <= 21) {
            $message = "Banken vann!";
        }
        
            
            $data = [
                "userpoints"=> $userpoints,
                "bankpoints"=> $bankpoints,
                "cardhand"=> $cardhand,
                "bankhand"=> $bankhand,
                "message"=> $message
            ];

        return $this->render('game/game_score.html.twig', $data);
    }
}