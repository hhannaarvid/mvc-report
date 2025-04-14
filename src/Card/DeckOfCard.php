<?php

namespace App\Card;

class DeckOfCard
{
    protected $deck;

    public function __construct()
    {
        // konstruktor
        $this->deck = [];
    }


    public function getDeck() 
    {
        // ta fram hela kortleken
        return $this->deck;

    }
}