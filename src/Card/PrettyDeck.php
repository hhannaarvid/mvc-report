<?php

namespace App\Card;

class PrettyDeck extends DeckOfCard

{
    protected array $cards = []; //sorterad
    protected array $suits = ['♥', '♦', '♣', '♠'];
    protected array $ranks = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];

    public function __construct()
    {
        foreach ($this->suits as $suit) {
            foreach ($this->ranks as $rank) {
                $this->cards[] = new Card($suit, $rank);
            }
        }
    }
}
