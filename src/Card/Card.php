<?php

namespace App\Card;

/**
 * skapar klassen Card (ett kort) med två argument, en rank och en suit.
 */
class Card
{
    protected string $suit;
    protected string $rank;

    /**
     * konstruktor för klassen, tar emot två argument(strängar) som tillsammans skapar ett
     * kortobjekt.
     */
    public function __construct(string $suit, string $rank)
    {
        $this->suit = $suit;
        $this->rank = $rank;
    }

    /**
     * gör om kortobjektet till en sträng.
     */
    public function getCardString(): string
    {
        return "{$this->suit}{$this->rank}";
    }

    /** hämtar kortets "rank", dvs värdet på siffran. */
    public function getRank(): int
    {
        return (int) $this->rank;
    }


}
