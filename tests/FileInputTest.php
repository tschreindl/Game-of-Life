<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

use GameOfLife\Board;
use GameOfLife\Field;
use Input\FileInput;
use PHPUnit\Framework\TestCase;

require_once "GetOptMock.php";

/**
 * Tests that the class FileInput works as expected.
 */
class FileInputTest extends TestCase
{
    function testFillBoard()
    {
        $count = 0;
        $falseCount = 0;
        $mustBeAlive = 10;

        $board = new Board(100, 100);
        $board->initEmpty();
        $fileInput = new FileInput();
        $options = new  GetOptMock();
        $fileInput->fillBoard($board, $options->createOpt());
        foreach ($board->board as $line)
        {
            foreach ($line as $field)
            {
                /** @var Field $field */
                if ($field->isAlive() == true)
                {
                    $count++;
                    $this->assertTrue($field->isAlive());
                }
                if ($field->isAlive() == false)
                {
                    $falseCount++;
                    $this->assertFalse($field->isAlive());
                }
            }
            $this->assertEquals($board->height(), count($line));
        }
        $this->assertEquals($mustBeAlive, $count);
        $this->assertEquals($board->width() * $board->height() - $mustBeAlive, $falseCount);
        $this->assertNotEmpty($fileInput);
    }

    function testAddOptions()
    {
        $fileInput = new FileInput();
        $options = new GetOptMock();
        $fileInput->addOptions($options->createOpt());
        $this->assertNotEmpty($fileInput);
    }
}
