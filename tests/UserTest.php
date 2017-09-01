<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../Inputs/User.php";
require_once __DIR__ . "/../Board.php";

/**
 * Class UserTest
 */
class UserTest extends TestCase
{
    function testPrintBoard()
    {
        $count = 0;
        $falseCount = 0;
        $mustBeAlive = 5;
        $outString = "";

        $board = new \GameOfLife\Board(20,20);
        $board->initEmpty();

        $board->setField(2,2,true);
        $board->setField(3,3,true);
        $board->setField(4,4,true);
        $board->setField(5,5,true);
        $board->setField(6,6,true);


        $userInput = new \Input\User();
        $userInput->print($board);
        foreach ($board->board as $items)
        {
            foreach ($items as $item)
            {
                if ($item == true)
                {
                    $count++;
                    $this->assertTrue($item);
                    $outString = $outString . " x ";
                }
                if ($item == false)
                {
                    $falseCount++;
                    $this->assertFalse($item);
                    $outString = $outString . "   ";
                }
            }
            $outString = $outString . "|\n";
            $this->assertEquals($board->height, count($items));
        }
        for ($strokes = 1; $strokes <= $board->width; $strokes++)
        {
            $outString = $outString . "---";
        }
        $outString = $outString . "\n";

        $this->expectOutputString($outString);
        $this->assertEquals($mustBeAlive, $count);
        $this->assertEquals($board->width*$board->height-$mustBeAlive, $falseCount);
        $this->assertNotEmpty($userInput);
    }

}
