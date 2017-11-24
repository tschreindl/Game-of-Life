<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

use GameOfLife\Board;
use GameOfLife\Field;
use Output\ConsoleOutput;
use PHPUnit\Framework\TestCase;

require_once "GetOptMock.php";

/**
 * Tests that the class ConsoleOutput works as expected.
 */
class ConsoleOutputTest extends TestCase
{
    function testStartOutput()
    {
        $consoleOutput = new ConsoleOutput();
        $options = new GetOptMock();
        $consoleOutput->startOutput($options->createOpt());
        $this->expectOutputString("Ausgabe in Konsole erfolgt...\n");
    }

    function testOutputBoard()
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


        $consoleOutput = new ConsoleOutput();
        $options = new GetOptMock();
        $consoleOutput->outputBoard($board, $options->createOpt());

        $outString = $outString . "Aktuelle Generation: 0\n┌";
        for ($strokes = 1; $strokes <= $board->width(); $strokes++)
        {
            $outString = $outString . "───";
        }
        $outString = $outString . "─────┐\n";


        foreach ($board->board as $line)
        {
            $outString = $outString . "│";
            foreach ($line as $field)
            {
                /** @var Field $field */
                if ($field->isAlive() == true)
                {
                    $count++;
                    $this->assertTrue($field->isAlive());
                    $outString = $outString . " ¤ ";
                }
                if ($field->isAlive() == false)
                {
                    $falseCount++;
                    $this->assertFalse($field->isAlive());
                    $outString = $outString . "   ";
                }
            }
            $outString = $outString . "│\n";
            $this->assertEquals($board->height(), count($line));
        }
        $outString = $outString . "└";
        for ($strokes = 1; $strokes <= $board->width(); $strokes++)
        {
            $outString = $outString . "───";
        }
        $outString = $outString . "─────┘\n";

        $this->expectOutputString($outString);
        $this->assertEquals($mustBeAlive, $count);
        $this->assertEquals($board->width() * $board->height() - $mustBeAlive, $falseCount);
        $this->assertNotEmpty($consoleOutput);
    }

    function testAddOptions()
    {
        $options = new GetOptMock();
        $consoleOutput = new ConsoleOutput();
        $consoleOutput->addOptions($options->createOpt());
        $this->assertNotEmpty($consoleOutput);
    }

}
