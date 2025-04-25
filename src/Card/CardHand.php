<?php

namespace App\Card;

class CardHand
{
    /** @var Card[] */
    protected array $cardhand = [];

    public function add(Card $card): void
    {
        $this->cardhand[] = $card;

    }

    /** @return Card[] */
    public function getCardHand(): array
    {
        return $this->cardhand;
    }

    /** @return String[] */
    public function getString(): array
    {
        $cards = [];
        foreach ($this->cardhand as $card) {
            $cards[] = $card->getCardString();
        }
        return $cards;
    }

    /** @return String[] */
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
