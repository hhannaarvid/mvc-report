<?php

namespace App\Card;

use App\Card\DeckOfCard;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ProjHelp
{
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

    public function score2(int $userpoints, int $bankpoints, string $playername): string
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


    public function score3(int $userpoints, int $bankpoints): string
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

    public function start1(SessionInterface $session, string $user): void
    {
        $deck = $session->get('gameDeck');

        $hand = [];

        for ($i = 1; $i <= 2; $i++) {
                //dra ett kort
                $draw = $deck->draw();
                //spara draget kort som sträng i array
                $hand[] = $draw->getCardString();
            }
            //spara startkort för spelare1
            $session->set($user, $hand);
    }

    public function startbank(SessionInterface $session): void
    {
        $deck = $session->get('gameDeck');
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
                if (($points + 11) <= 21) {
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


    public function winnings(int $points, string $win): float
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
