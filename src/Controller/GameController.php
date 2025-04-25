<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use App\Card\DeckOfCard;

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

        //skapa rätt variabler i session
        $session->set("userpoints", 0);
        $session->set("draws", 0);
        $session->set("bankpoints", 0);
        $session->set("cardhand", []);
        $session->set("bankhand", []);

        if (!$session->has("bank-wins") || !$session->has("user-wins")) {
            $session->set("user-wins", 0);
            $session->set("bank-wins", 0);
        }

        //skapa ny kortlek
        $deck = new DeckOfCard();

        // blanda kortleken
        $deck->shuffle();

        //spara blandad kortlek (objekt) i session
        $session->set("gameDeck", $deck);

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
        //skapa ny kortlek
        $deck = new DeckOfCard();

        // blanda kortleken
        $deck->shuffle();

        //hur många kort ska banken dra
        $number = rand(2, 3);
        $bankhand = [];
        //dra ett kort
        for ($i = 1; $i <= $number; $i++) {
            $draw = $deck->draw();
            if ($draw === null) {
                continue;
            }
            $bankhand[] = $draw->getCardString();
            //ta fram poäng för kortet
            $rank = $draw->getRank();
            $points = $session->get("bankpoints");
            $total = $rank + $points;

            $session->set("bankpoints", $total);
        }

        $session->set("bankhand", $bankhand);

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
        $userpoints = $session->get("userpoints");
        $bankpoints = $session->get("bankpoints");
        $message = "";
        $bankwins = $session->get("bank-wins");
        $userwins = $session->get("user-wins");

        if ($userpoints > 21 && $bankpoints > 21) {
            $message = "Båda fick över 21, alltså vann ingen.";
        }
    
        if ($userpoints === $bankpoints) {
            $message = "Banken vann!";
            $bankwins += 1;
            $session->set("bank-wins", $bankwins);
        }
    
        if ($userpoints > 21) {
            $message = "Banken vann!";
            $bankwins += 1;
            $session->set("bank-wins", $bankwins);
        }
    
        if ($bankpoints > 21) {
            $message = "Du vann!";
            $userwins += 1;
            $session->set("user-wins", $userwins);
        }
    
        if ($userpoints > $bankpoints) {
            $message = "Du vann!";
            $userwins += 1;
            $session->set("user-wins", $userwins);
        }
    
        if ($message === "") {
            $message = "Banken vann!";
            $bankwins += 1;
            $session->set("bank-wins", $bankwins);
        }

        $data = [
            "userpoints" => $userpoints,
            "bankpoints" => $bankpoints,
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
