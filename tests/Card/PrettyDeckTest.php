<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * test case for the class Card.
 */
class PrettyDeckTest extends TestCase
{
    public function testCreatePrettyDeck(): void
    {
        $deck = new PrettyDeck();
        $this->assertInstanceOf("\App\Card\PrettyDeck", $deck);
    }
}
