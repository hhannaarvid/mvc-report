<?php

namespace App\Card;

use App\Card\DeckOfCard;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class GameHelp
{
    public function createDeck(): DeckOfCard
    {
        //skapa ny kortlek
        $deck = new DeckOfCard();

        // blanda kortleken
        $deck->shuffle();

        return $deck;
    }

    public function startGame(SessionInterface $session): void
    {
        $deck = $this->createDeck();
        //spara blandad kortlek (objekt) i session
        $session->set("gameDeck", $deck);

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


    }
    public function bank(SessionInterface $session): void
    {
        $deck = $this->createDeck();

        //hur många kort ska banken dra
        $number = rand(2, 3);
        $bankhand = [];
        //dra ett kort
        for ($i = 1; $i <= $number; $i++) {
            $draw = $deck->draw();
            if (!$draw) {
                continue;
            }
            $bankhand[] = $draw->getCardString();
            //ta fram poäng för kortet
            $points = $session->get("bankpoints", 0);
            $session->set("bankpoints", $points + $draw->getRank());
        }

        $session->set("bankhand", $bankhand);
    }
    public function score(SessionInterface $session): string
    {
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
        return $message;
    }

    public function userPlay(SessionInterface $session): void
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
    }
}
