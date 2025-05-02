<?php

namespace App\Card;

/** klass för CardHand. Skapas utifrån att man har några kortobjekt som
 * tillsammans utgör en korthand. 
 */
class CardHand
{
    /** @var Card[] */
    protected array $cardhand = [];

    /**
     * lägger till ett kortobjekt i card[].
     */
    public function add(Card $card): void
    {
        $this->cardhand[] = $card;

    }

    /** 
     * Returnerar cardhand som den är.
     * @return Card[] 
    */
    public function getCardHand(): array
    {
        return $this->cardhand;
    }

    /** 
     * Returnerar en array med strängar.
     * @return String[] */
    public function getString(): array
    {
        $cards = [];
        foreach ($this->cardhand as $card) {
            $cards[] = $card->getCardString();
        }
        return $cards;
    }

    /** 
     * Returnerar en array med strängar.
     * @return String[] */
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
