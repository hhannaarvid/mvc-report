<?php

namespace App\Card;

use PHPUnit\Framework\TestCase;

/**
 * test case for the class Card.
 */
class CardHandTest extends TestCase
{
    /**
     * test for creating cardhand-object!
     */
    public function testCreateCardHandObject(): void
    {
        //alla behövs kanske inte?
        $card1 = new Card("h", "7");
        $card2 = new Card("c", "5");

        $cardhand = new CardHand();
        $cardhand->add($card1);
        $cardhand->add($card2);

        $this->assertInstanceOf("\App\Card\CardHand", $cardhand);
    }

    public function testGetCardhandArray(): void
    {
        $card1 = new Card("h", "7");
        $card2 = new Card("c", "5");

        $cardhand = new CardHand();
        $cardhand->add($card1);
        $cardhand->add($card2);

        $cardarrayobj = $cardhand->getCardHand();
        $this->assertEquals(count($cardarrayobj), 2);
        $this->assertContains($card1, $cardarrayobj);

        $cardarray = $cardhand->cardsArray();
        $this->assertEquals(count($cardarray), 2);
        $this->assertContains("h7", $cardarray);
        $this->assertContains("c5", $cardarray); 
    }

    // public function testGetCardHandString(): void
    // {
    //     $card1 = new Card("h", "7");
    //     $card2 = new Card("c", "5");

    //     $cardhand = new CardHand();
    //     $cardhand->add($card1);
    //     $cardhand->add($card2);

    //     $cardarray = $cardhand->getString();
    //     $this->assertEquals(count($cardarray), 2);
    //     $this->assertContains("h7", $cardarray);
    //     $this->assertContains("c5", $cardarray);
    // }
}
