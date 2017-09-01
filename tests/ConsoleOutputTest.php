<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../Outputs/ConsoleOutput.php";
require_once __DIR__ . "/../Board.php";
require_once "GetOptMock.php";

/**
 * Class ConsoleOutputTest
 */
class ConsoleOutputTest extends TestCase
{
    function testOutputBoard()
    {
        $count = 0;
        $falseCount = 0;
        $mustBeAlive = 5;
        $outString = "";

        $board = new \GameOfLife\Board(20, 20);
        $board->initEmpty();

        $board->setField(2, 2, true);
        $board->setField(3, 3, true);
        $board->setField(4, 4, true);
        $board->setField(5, 5, true);
        $board->setField(6, 6, true);


        $consoleOutput = new \Output\ConsoleOutput();
        $options = new GetOptMock();
        $consoleOutput->outputBoard($board, $options->createOpt());

        $outString = $outString . "Aktuelle Generation: 0\n┌";
        for ($strokes = 1; $strokes <= $board->width; $strokes++)
        {
            $outString = $outString . "───";
        }
        $outString = $outString . "─────┐\n";


        foreach ($board->board as $items)
        {
            $outString = $outString . "│";
            foreach ($items as $item)
            {
                if ($item == true)
                {
                    $count++;
                    $this->assertTrue($item);
                    $outString = $outString . " ¤ ";
                }
                if ($item == false)
                {
                    $falseCount++;
                    $this->assertFalse($item);
                    $outString = $outString . "   ";
                }
            }
            $outString = $outString . "│\n";
            $this->assertEquals($board->height, count($items));
        }
        $outString = $outString . "└";
        for ($strokes = 1; $strokes <= $board->width; $strokes++)
        {
            $outString = $outString . "───";
        }
        $outString = $outString . "─────┘\n";

        $this->expectOutputString($outString);
        $this->assertEquals($mustBeAlive, $count);
        $this->assertEquals($board->width * $board->height - $mustBeAlive, $falseCount);
        $this->assertNotEmpty($consoleOutput);
    }

}
