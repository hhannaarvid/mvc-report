<?php

namespace App\Card;

class DeckOfCard
{
    protected array $cards = []; //sorterad
    protected array $shuffled = []; //blandad

    protected array $suits = ['h', 'd', 'c', 's'];
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
            $deckArr[] = $card->getCardString();
        }
        return $deckArr;
    }

    public function getAsString(): string
    {
        //hämtar kortlek som sträng
        $deckStr = [];

        foreach ($this->cards as $card) {
            $deckStr[] = $card->getCardString();
        }

        return implode(', ', $deckStr);
        // return $deckStr;

    }

    public function shuffleDeck(): array
    {
        // blandar kortleken
        $deckArr = [];

        foreach ($this->cards as $card) {
            $deckArr[] = $card->getCardString();
        }
        shuffle($deckArr);
        $this->shuffled = $deckArr;
        return $deckArr;

    }

    public function shuffle(): void
    {
        shuffle($this->cards);
    }

    public function draw(): Card
    {
        return array_shift($this->cards);
    }

    public function cardsCount(): int
    {
        return count($this->cards);
    }
}
