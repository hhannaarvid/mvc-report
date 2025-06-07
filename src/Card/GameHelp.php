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
        //skapa ny kortlek med metod
        $deck = $this->createDeck();

        //spara blandad kortlek (objekt) i session
        $session->set("gameDeck", $deck);

        //skapa rätt variabler i session
        $session->set("userpoints", 0);
        $session->set("bankpoints", 0);
        $session->set("cardhand", []);
        $session->set("bankhand", []);
        // $session->set("draws", 0);


        // skapa poäng för bank och spelare om det inte finns.
        if (!$session->has("bank-wins") || !$session->has("user-wins")) {
            $session->set("user-wins", 0);
            $session->set("bank-wins", 0);
        }
    }


    public function bank(SessionInterface $session): void
    { // ORIGINAL
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

    public function userPlay(SessionInterface $session): void
    {
        // hämta kortlek från session
        $deck = $session->get("gameDeck");

        //hämta korthand från session
        $cardhand = $session->get("cardhand");

        //dra ett kort
        $draw = $deck->draw();

        //spara draget kort som sträng i array
        $cardhand[] = $draw->getCardString();

        //spara korthand i session
        $session->set("cardhand", $cardhand);

        //ta fram poäng för kortet
        $rank = $draw->getRank();

        // hämta användarpoäng från session
        $points = $session->get("userpoints");

        //räkna ut totalpoäng
        $total = $rank + $points;

        //spara nya poäng i session
        $session->set("userpoints", $total);

        //spara kortlek i session
        $session->set("gameDeck", $deck);
    }

    public function score(SessionInterface $session): string
    {
        $userpoints = $session->get("userpoints");
        $bankpoints = $session->get("bankpoints");
        $bankwins = $session->get("bank-wins");
        $userwins = $session->get("user-wins");

        if ($userpoints > 21 && $bankpoints > 21) {
            return "Båda fick över 21, alltså vann ingen.";
        } elseif ($userpoints === $bankpoints) {
            $bankwins += 1;
            $session->set("bank-wins", $bankwins);
            return "Oavgjort!";
        } elseif ($userpoints > 21) {

            $bankwins += 1;
            $session->set("bank-wins", $bankwins);
            return "Banken vann!";
        } elseif ($bankpoints > 21) {

            $userwins += 1;
            $session->set("user-wins", $userwins);
            return "Du vann!";
        } elseif ($userpoints > $bankpoints) {

            $userwins += 1;
            $session->set("user-wins", $userwins);
            return "Du vann!";
        } else {

            $bankwins += 1;
            $session->set("bank-wins", $bankwins);
            return "Banken vann!";
        }
    }

}
