<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * test case for the class Card.
 */
class CardTest extends TestCase
{
    public function testCreateCardObject(): void
    {
        $card = new Card("h", "7");
        $this->assertInstanceOf("\App\Card\Card", $card);
    }

    public function testGetString(): void
    {
        $card = new Card("h", "7");
        $cardstr = $card->getCardString();
        $this->assertEquals("h7", $cardstr);
    }

    public function testGetRank(): void
    {
        $card = new Card("h", "7");
        $rank = $card->getRank();
        $this->assertEquals("7", $rank);
    }
}
