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
    public function testCreatePrettyDeck(): void
    {
        $deck = new DeckOfCard();
        $this->assertInstanceOf("\App\Card\DeckOfCard", $deck);
    }

    /**
     * tests methods for making object into array and array of strings.
     */
    public function testArrayAndString(): void
    {
        $deck = new DeckOfCard();
        $deckarray = $deck->cardsArray();
        // $deckstr = $deck->getAsString();

        $this->assertEquals(count($deckarray), 52);
        $this->assertNotEmpty($deckarray);
        $this->assertContains("h7", $deckarray);
    }

    /**
     * tests method to shuffle deck
     */
    public function testShuffleDeck(): void
    {
        $deck = new DeckOfCard();
        $deckArr = $deck->cardsArray();
        $shuffled = new DeckOfCard();

        $shuffled->shuffle();
        $shuffledArr = $shuffled->cardsArray();

        $this->assertNotEquals($deckArr, $shuffledArr);
    }

    public function testDraw(): void
    {
        $deck = new DeckOfCard();
        $deckarr = $deck->cardsArray();
        $length = count($deckarr);

        $onecard = $deck->draw();

        $this->assertInstanceOf("\App\Card\Card", $onecard);
        $this->assertEquals($length - 1, $deck->cardsCount());

    }
}
