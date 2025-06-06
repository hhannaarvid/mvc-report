<?php

namespace App\Card;

use App\Card\DeckOfCard;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Validator\Constraints\Length;

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


    public function bank2(SessionInterface $session): void
    {
        // hämta kortlek från session
        $deck = $session->get('gameDeck');

        // skapa array för bankens korthand
        $bankhand = $session->get('bankhand');

        //dra ett kort
        $draw = $deck->draw();

        //spara dragna kortet som sträng i bankens korthand
        $bankhand[] = $draw->getCardString();

        // spara bankens korthand i session
        $session->set("bankhand", $bankhand);

        //spara kortlek i session
        $session->set("gameDeck", $deck);

        //räkna poäng
        $bankpoints = $this->countPoints($bankhand);

        $session->set("bankpoints", $bankpoints);


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

    public function score2($userpoints, $bankpoints, $playername): string
    {
        $message = "";

        if ($userpoints > 21 && $bankpoints > 21) {
            $message = "Båda fick över 21, alltså vann ingen.";
        } elseif ($userpoints === $bankpoints) {
            $message = "Oavgjort.";
        } elseif ($userpoints > 21) {
            $message = "Banken vann över $playername!";
        } elseif ($bankpoints > 21) {
            $message = "$playername vann över banken!";
        } elseif ($userpoints > $bankpoints) {
            $message = "$playername vann över banken!";
        } else {
            $message = "Banken vann över $playername!";
        }
        return $message;
    }

        public function score3($userpoints, $bankpoints): string
    {
        $win = "no";

        if ($userpoints > 21 && $bankpoints > 21) {
            return $win;
        } elseif ($userpoints === $bankpoints) {
            $win = "equal";
            return $win;
        } elseif ($userpoints > 21) {
            return $win;
        } elseif ($bankpoints > 21) {
            $win = "yes";
            return $win;
        } elseif ($userpoints > $bankpoints) {
            $win = "yes";
            return $win;
        } else {
            return $win;
        }

    }


    public function startDraws(SessionInterface $session, $players): void
    {
        // hämta kortlek
        $deck = $session->get('gameDeck');

        //tom bank
        $bank = [];

        //spelare
        $user1 = [];
        $user2 = [];
        $user3 = [];

        if ($players === 1) {
            for ($i = 1; $i <= 2; $i++){
                //dra ett kort
                $draw = $deck->draw();
                //spara draget kort som sträng i array
                $user1[] = $draw->getCardString();
            }
            //spara startkort för spelare1
            $session->set("user1", $user1);
        }
        if ($players === 2) {
            for ($i = 1; $i <= 2; $i++){
                //dra ett kort
                $draw = $deck->draw();
                //spara draget kort som sträng i array
                $user1[] = $draw->getCardString();
            }
            for ($i = 1; $i <= 2; $i++){
                //dra ett kort
                $draw = $deck->draw();
                //spara draget kort som sträng i array
                $user2[] = $draw->getCardString();
            }
            $session->set("user1", $user1);
            $session->set("user2", $user2);
        }
        if ($players === 3) {
            for ($i = 1; $i <= 2; $i++){
                //dra ett kort
                $draw = $deck->draw();
                //spara draget kort som sträng i array
                $user1[] = $draw->getCardString();
            }
            for ($i = 1; $i <= 2; $i++){
                //dra ett kort
                $draw = $deck->draw();
                //spara draget kort som sträng i array
                $user2[] = $draw->getCardString();
            }
            for ($i = 1; $i <= 2; $i++){
                //dra ett kort
                $draw = $deck->draw();
                //spara draget kort som sträng i array
                $user3[] = $draw->getCardString();
            }
            $session->set("user1", $user1);
            $session->set("user2", $user2);
            $session->set("user3", $user3);

            
        }
        //bankens första kort
        $draw = $deck->draw();
        $bank[] = $draw->getCardString();
        $session->set('bankhand', $bank);
    }

    public function countPoints($cardhand): int
    {
        // räkna ut poäng för en hand med kort
        $points = 0;

        foreach ($cardhand as $card) {
            $rank = substr($card, 1);

            if ($rank === '11' || $rank === '12' || $rank === '13') {
                $points += 10;
            } elseif ($rank === '14') {
                if (($points + 11) <= 21){
                    $points += 11;
                } else {
                    $points += 1;
                }
            } else {
                $points += (int) $rank;
            }
        }

        return $points;
    }

    public function winnings($points, $win): int
    {
        if ($win === 'yes') {
            if ($points === 21) {
                return 2.5;
            } else {
                return 2;
            }
        } elseif ($win === 'equal') {
            return 1;
        } else {
            return 0;
        }

    }
}

//     public function userPlay(SessionInterface $session): void
// {
//     // hämta kortlek från session
//     $deck = $session->get("gameDeck");
//     //hämta korthand från session
//     $cardhand = $session->get("cardhand");


//     //dra ett kort
//     $draw = $deck->draw();
//     //spara draget kort som sträng i array
//     $cardhand[] = $draw->getCardString();
//     //spara korthand i session
//     $session->set("cardhand", $cardhand);

//     //ta fram poäng för kortet
//     $rank = $draw->getRank();
//     // hämta användarpoäng från session
//     $points = $session->get("userpoints");
//     //räkna ut totalpoäng
//     $total = $rank + $points;
//     //spara nya poäng i session
//     $session->set("userpoints", $total);
// }
