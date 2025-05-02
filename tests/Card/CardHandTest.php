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
    public function testCreateCardHandObject()
    {
        //alla behövs kanske inte?
        $card1 = new Card("h", "7");
        $card2 = new Card("c", "5");
        // $card3 = new Card("d", "9");
        // $card4 = new Card("s", "2");

        $cardhand = new CardHand();
        $cardhand->add($card1);
        $cardhand->add($card2);
        // $cardhand->add($card3);
        // $cardhand->add($card4);

        $this->assertInstanceOf("\App\Card\CardHand", $cardhand);
    }

    public function testGetCardhandArray()
    {
        $card1 = new Card("h", "7");
        $card2 = new Card("c", "5");

        $cardhand = new CardHand();
        $cardhand->add($card1);
        $cardhand->add($card2);

        $cardarrayobj = $cardhand->getCardHand();
        $this->assertTrue(is_array($cardarrayobj));
        $this->assertContains($card1, $cardarrayobj);

        $cardarray = $cardhand->cardsArray();
        $this->assertTrue(is_array($cardarray));

    }

    public function testGetCardHandString()
    {
        $card1 = new Card("h", "7");
        $card2 = new Card("c", "5");

        $cardhand = new CardHand();
        $cardhand->add($card1);
        $cardhand->add($card2);

        $cardstr = $cardhand->getString();
        $this->assertTrue(is_array($cardstr));
        $this->assertContains("h7", $cardstr);
    }
}
