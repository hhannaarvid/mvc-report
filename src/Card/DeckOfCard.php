<?php

namespace App\Card;

class DeckOfCard extends Card
{
    protected array $cards = []; //sorterad
    
    protected array $shuffled = []; //blandad


    // protected array $suits = ['♥', '♦', '♣', '♠'];
    protected array $suits = ['h', 'd', 'c', 's'];

    // protected array $ranks = ['2', '3', '4', '5', '6', '7', '8', '9', '10', 'J', 'Q', 'K', 'A'];
    protected array $ranks = ['2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14'];


    public function __construct()
    {
        foreach ($this->suits as $suit) {
            foreach ($this->ranks as $rank) {
                $this->cards[] = new Card($suit, $rank);
            }
        }

    }

    public function cardsArray(): array
    {
        // hämtar kortlek som Array
        $deckArr = [];

        foreach ($this->cards as $card) {
            $deckArr[] = $card->getAsString();
        }
        return $deckArr;
    }

    public function getAsString(): string // behövs kanske inte ens???????
    {
        //hämtar kortlek som sträng
        $deckStr = [];

        foreach ($this->cards as $card) {
            $deckStr[] = $card->getAsString();
        }

        return implode(', ', $deckStr);
        // return $deckStr;

    }

    public function shuffleDeck(): array
    {
        // blandar kortleken
        $deckArr = [];

        foreach ($this->cards as $card) {
            $deckArr[] = $card->getAsString();
        }
        shuffle($deckArr);
        $this->shuffled = $deckArr;
        return $deckArr;

    }

    public function shuffleDeck2(): void
    {
        // blandar kortleken
        shuffle($this->cards);

    }


    // public function draw(): ?Card
    // {
    //     return array_shift($this->cards);
    // }

    // public function cardsLeft(): int
    // {
    //     return count($this->cards);
    // }


}