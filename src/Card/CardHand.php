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
     * Returnerar en array av objekt.
     * @return Card[]
    */
    public function getCardHand(): array
    {
        return $this->cardhand;
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
