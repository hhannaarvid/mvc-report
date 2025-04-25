<?php

namespace App\Card;

class Card
{
    protected string $suit;
    protected string $rank;

    public function __construct(string $suit, string $rank)
    {
        $this->suit = $suit;
        $this->rank = $rank;
    }

    public function getCardString(): string
    {
        return "{$this->suit}{$this->rank}";
    }

    public function getRank(): int
    {
        return (int) $this->rank;
    }


}
