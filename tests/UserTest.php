<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

use GameOfLife\Board;
use Input\User;
use PHPUnit\Framework\TestCase;

require_once "GetOptMock.php";

/**
 * Tests that the class User works as expected.
 */
class UserTest extends TestCase
{
    function testFillBoard()
    {
        //this is needed so that it works :-/
        $GLOBALS["__user_unit_test"] = true;
        $board = new Board(20, 20);
        $user = new User();
        $options = new GetOptMock();
        $user->fillBoard($board, $options->createOpt());
        $this->expectOutputString(
            "------------------------------------------------------------\n" .
            "                                                            |\n" .
            "                                                            |\n" .
            "                                                            |\n" .
            "                                                            |\n" .
            "                                                            |\n" .
            "                                                            |\n" .
            "                                                            |\n" .
            "                                                            |\n" .
            "                                                            |\n" .
            "                                                            |\n" .
            "                                                            |\n" .
            "                                                            |\n" .
            "                                                            |\n" .
            "                                                            |\n" .
            "                                                            |\n" .
            "                                                            |\n" .
            "                                                            |\n" .
            "                                                            |\n" .
            "                                                            |\n" .
            "                                                            |\n" .
            "------------------------------------------------------------\n" .
            "\nEnter the coordinates of the cell that you want to set/unset" .
            "\nEnter 's' or 'start' to start the simulation\n\n");

        //cleanup messy stuff
        unset($GLOBALS["__user_unit_test"]);
    }

    function testPrintBoard()
    {
        $count = 0;
        $falseCount = 0;
        $mustBeAlive = 5;
        $outString = "";

        $board = new Board(20, 20);
        $board->initEmpty();

        $board->setField(2, 2, true);
        $board->setField(3, 3, true);
        $board->setField(4, 4, true);
        $board->setField(5, 5, true);
        $board->setField(6, 6, true);


        $userInput = new User();
        $userInput->print($board);
        foreach ($board->board as $items)
        {
            foreach ($items as $item)
            {
                if ($item->isAlive() == true)
                {
                    $count++;
                    $this->assertTrue($item->isAlive());
                }
                if ($item->isAlive() == false)
                {
                    $falseCount++;
                    $this->assertFalse($item->isAlive());
                }
            }
            $this->assertEquals($board->height, count($items));
        }

        $this->assertEquals($mustBeAlive, $count);
        $this->assertEquals($board->width * $board->height - $mustBeAlive, $falseCount);
        $this->assertNotEmpty($userInput);
    }

    function testAddOptions()
    {
        $user = new User();
        $options = new GetOptMock();
        $user->addOptions($options->createOpt());
        $this->assertNotEmpty($user);
    }
}
