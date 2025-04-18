<?php

namespace App\Card;

class CardHand
{
    protected array $cardhand = [];

    public function add(Card $card): void
    {
        $this->cardhand[] = $card;

    }

    public function getCardHand(): array
    {
        return $this->cardhand;
    }

    public function getString(): array
    {
        $cards = [];
        foreach ($this->cardhand as $card) {
            $cards[] = $card->getCardString();
        }
        return $cards;
    }

    public function cardsArray(): array
    {
        // hämtar kortlek som Array
        $deckArr = [];

        foreach ($this->cardhand as $card) {
            $deckArr[] = $card->getCardString();
        }
        return $deckArr;
    }



}
