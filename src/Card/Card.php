<?php

namespace App\Card;

class Card
{
    protected $card;

    public function __construct()
    {
        // konstruktor
        $this->card = null;
    }


    public function getcard(): string
    {
        $this->card = "[A♥]";
        return $this->card;
    }

    // public function getAsString(): string
    // {
    //     return "[{$this->$card}]";
    // }
}