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

    // public function getSuit(): string
    // {
    //     return $this->suit;
    // }

    // public function getRank(): string
    // {
    //     return $this->rank;
    // }

    public function getAsString(): string
    {
        return "{$this->suit}{$this->rank}";
    }

    public function imgStr(): string
    {
        // fixa adress till bilderna
        $rank = $this->rank;
        $suit = $this->suit;

        return "/img/deck/{$suit}{$rank}.svg";
    }
}