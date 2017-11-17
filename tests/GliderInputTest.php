<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

use GameOfLife\Board;
use Input\GliderInput;
use PHPUnit\Framework\TestCase;

require_once "GetOptMock.php";

/**
 * Tests that the class GliderInput works as expected.
 */
class GliderInputTest extends TestCase
{
    function testFillBoard()
    {
        $count = 0;
        $board = new Board(30, 20);
        $board->initEmpty();
        $random = new GliderInput();
        $options = new  GetOptMock();
        $random->fillBoard($board, $options->createOpt());
        foreach ($board->board as $item)
        {
            foreach ($item as $val)
            {
                if ($val->isAlive() == true) $count++;
                //$this->assertEquals(true, $val); //must set $percent = 100 in RandomInput.php to pass
            }
            $this->assertEquals($board->height, count($item));
        }
        $this->assertEquals(5, $count);
        $this->assertNotEmpty($random);
    }

    function testAddOptions()
    {
        $options = new GetOptMock();
        $glider = new \Input\GliderInput();
        $glider->addOptions($options->createOpt());
        $this->assertNotEmpty($glider);
    }
}