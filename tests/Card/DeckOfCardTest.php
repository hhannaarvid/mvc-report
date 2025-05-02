<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/** 
 * test case for the class Card. 
 */
class DeckOfCardTest extends TestCase
{
    /**
     * test for creating object of DeckOfCard-class.
     */
    public function testCreatePrettyDeck() {
        $deck = new DeckOfCard();
        $this->assertInstanceOf("\App\Card\DeckOfCard", $deck);
    }

    /**
     * tests methods for making object into array and array of strings.
     */
    public function testArrayAndString() {
        $deck = new DeckOfCard();
        $deckarray = $deck->cardsArray();
        $deckstr = $deck->getAsString();

        $this->assertTrue(is_array($deckarray));
        $this->assertTrue(is_string($deckstr[0]));
    }

    /**
     * tests method to shuffle deck
     */
    public function testShuffleDeck() {
        $deck = new DeckOfCard(); 
        $deckArr = $deck->cardsArray();
        $shuffled = new DeckOfCard();

        $shuffled->shuffle();
        $shuffledArr = $shuffled->cardsArray();
        
        $this->assertNotEquals($deckArr, $shuffledArr);
    }

    public function testDraw() {
        $deck = new DeckOfCard();
        $deckarr = $deck->cardsArray();
        $length = count($deckarr);

        $onecard = $deck->draw();

        $this->assertInstanceOf("\App\Card\Card", $onecard);
        $this->assertEquals($length -1, $deck->cardsCount());

    }
}