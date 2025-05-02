<?php

namespace App\Card;

/**
 * klass för att skapa en hel kortlek.
 */
class DeckOfCard
{
    /** @var Card[] */
    protected array $cards = []; //sorterad

    /** @var String[] */
    protected array $suits = ['h', 'd', 'c', 's'];

    /** @var String[] */
    protected array $ranks = ['2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12', '13', '14'];

    /**
     * konstruktor för klassen som genererar en sorterad kortlek.
     */
    public function __construct()
    {
        foreach ($this->suits as $suit) {
            foreach ($this->ranks as $rank) {
                $this->cards[] = new Card($suit, $rank);
            }
        }
    }

    /**
     * Returnerar en array med strängar.
     * @return String[] */
    public function cardsArray(): array
    {
        // hämtar kortlek som Array
        $deckArr = [];

        foreach ($this->cards as $card) {
            $deckArr[] = $card->getCardString();
        }
        return $deckArr;
    }

    /**
     * returnerar en sträng.
     */
    public function getAsString(): string
    {
        //hämtar kortlek som sträng
        $deckStr = [];

        foreach ($this->cards as $card) {
            $deckStr[] = $card->getCardString();
        }

        return implode(', ', $deckStr);
    }

    // /** @return String[] */
    // public function shuffleDeck(): array
    // {
    //     // blandar kortleken
    //     $deckArr = [];

    //     foreach ($this->cards as $card) {
    //         $deckArr[] = $card->getCardString();
    //     }
    //     shuffle($deckArr);
    //     return $deckArr;

    // }

    /**
     * Blandar kortleken.
     */
    public function shuffle(): void
    {
        shuffle($this->cards);
    }

    /**
     * drar ett kort från kortleken.
     */
    public function draw(): ?Card
    {
        return array_shift($this->cards);
    }

    /**
     * räknar hur många kort som finns kvar i kortleken.
     */
    public function cardsCount(): int
    {
        return count($this->cards);
    }
}
