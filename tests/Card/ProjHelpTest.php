<?php

namespace App\Card;
use App\Card\ProjHelp;
use PHPUnit\Framework\TestCase;

/**
 * test case for the class ProjHelp.
 */
class ProjHelpTest extends TestCase
{
    public function testScore2ReturnsRightString(): void
    {
        $userpoints1 = 18;
        $bankpoints1 = 23;
        $playername = 'user1';
        $helper = new ProjHelp();
        $message1 = $helper->score2($userpoints1, $bankpoints1, $playername);
        $this->assertEquals("$playername vann över banken!", $message1);

        $bankpoints2 = 18;
        $message2 = $helper->score2($userpoints1, $bankpoints2, $playername);
        $this->assertEquals("Oavgjort.", $message2);

        $bankpoints3 = 16;
        $userpoints2 = 23;
        $message3 = $helper->score2($userpoints2, $bankpoints3, $playername);
        $this->assertEquals("Banken vann över $playername!", $message3);

        $message4 = $helper->score2($userpoints1, $bankpoints3, $playername);
        $this->assertEquals("$playername vann över banken!", $message4);

        $message5 = $helper->score2($userpoints2, $bankpoints1, $playername);
        $this->assertEquals("Båda fick över 21, alltså vann ingen.", $message5);
    }

    public function testScore2Winnings(): void
    {
        $userpoints1 = 18;
        $bankpoints1 = 24;
        $bankpoints2 = 18;
        $bankpoints3 = 16;
        $userpoints2 = 23;
        $helper = new ProjHelp();

        $win1 = $helper->score3($userpoints1, $bankpoints1);
        $this->assertEquals("yes", $win1);

        $win2 = $helper->score3($userpoints1, $bankpoints2);
        $this->assertEquals("equal", $win2);

        $win3 = $helper->score3($userpoints2, $bankpoints3);
        $this->assertEquals("no", $win3);

        $win4 = $helper->score3($userpoints2, $bankpoints1);
        $this->assertEquals("no", $win4);

        $win5 = $helper->score3($userpoints1, $bankpoints3);
        $this->assertEquals("yes", $win5);

    }

    public function testCountPointsForCardhand(): void
    {
        $cardhand = ['c11', 'd4', 'h14'];
        $cardhand2 = ['c3', 'd4', 'h14'];
        $helper = new ProjHelp();

        $points1 = $helper->countPoints($cardhand);
        $points2 = $helper->countPoints($cardhand2);

        $this->assertEquals(18, $points2);
        $this->assertEquals(15, $points1);

    }

    public function testCorrectWinnings(): void
    {
        $points = 21;
        $points2 = 18;
        $win1 = 'yes';
        $win2 = 'equal';
        $win3 = 'no';
        $helper = new ProjHelp();

        $winnings1 = $helper->winnings($points, $win1);
        $winnings2 = $helper->winnings($points2, $win1);
        $winnings3 = $helper->winnings($points2, $win2);
        $winnings4 = $helper->winnings($points2, $win3);

        $this->assertEquals(2.5, $winnings1);
        $this->assertEquals(2, $winnings2);
        $this->assertEquals(1, $winnings3);
        $this->assertEquals(0, $winnings4);
    }

}
