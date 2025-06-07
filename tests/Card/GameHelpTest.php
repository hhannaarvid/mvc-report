<?php

namespace App\Card;

use App\Card\GameHelp;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

/**
 * test case for the class ProjHelp.
 */
class GameHelpTest extends TestCase
{
    public function testCreateShuffledDeck(): void
    {
        $helper = new GameHelp();
        $deck = $helper->createDeck();
        $this->assertInstanceOf("\App\Card\DeckOfCard", $deck);
    }

    public function testScoreReturnsRightMessage(): void
    {
        $session = $this->createMock(SessionInterface::class);

        $session->method('get')
            ->willReturnMap([
                ["userpoints", null, 20],
                ["bankpoints", null, 20],
                ["bank-wins", null, 0],
                ["user-wins", null, 0]
            ]);

        $helper = new GameHelp();
        $message = $helper->score($session);
        $this->assertEquals("Oavgjort!", $message);

    }

    public function testScoreReturnsRightMessage2(): void
    {
        $session = $this->createMock(SessionInterface::class);

        $session->method('get')
            ->willReturnMap([
                ["userpoints", null, 20],
                ["bankpoints", null, 5],
                ["bank-wins", null, 0],
                ["user-wins", null, 0]
            ]);

        $helper = new GameHelp();
        $message = $helper->score($session);
        $this->assertEquals("Du vann!", $message);

    }

    public function testScoreReturnsRightMessage3(): void
    {
        $session = $this->createMock(SessionInterface::class);

        $session->method('get')
            ->willReturnMap([
                ["userpoints", null, 22],
                ["bankpoints", null, 18],
                ["bank-wins", null, 0],
                ["user-wins", null, 0]
            ]);

        $helper = new GameHelp();
        $message = $helper->score($session);
        $this->assertEquals("Banken vann!", $message);

    }

    public function testScoreReturnsRightMessage4(): void
    {
        $session = $this->createMock(SessionInterface::class);

        $session->method('get')
            ->willReturnMap([
                ["userpoints", null, 18],
                ["bankpoints", null, 24],
                ["bank-wins", null, 0],
                ["user-wins", null, 0]
            ]);

        $helper = new GameHelp();
        $message = $helper->score($session);
        $this->assertEquals("Du vann!", $message);

    }

    public function testScoreReturnsRightMessage5(): void
    {
        $session = $this->createMock(SessionInterface::class);

        $session->method('get')
            ->willReturnMap([
                ["userpoints", null, 24],
                ["bankpoints", null, 24],
                ["bank-wins", null, 0],
                ["user-wins", null, 0]
            ]);

        $helper = new GameHelp();
        $message = $helper->score($session);
        $this->assertEquals("Båda fick över 21, alltså vann ingen.", $message);

    }
}
