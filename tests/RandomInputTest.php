<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

use GameOfLife\Board;
use Input\RandomInput;
use PHPUnit\Framework\TestCase;

require_once "GetOptMock.php";

/**
 * Tests that the class RandomInput works as expected.
 */
class RandomInputTest extends TestCase
{
    function testFillBoard()
    {
        $GLOBALS["__user_unit_test"] = true;
        $board = new Board(30, 20);
        $board->initEmpty();
        $random = new RandomInput();
        $options = new  GetOptMock();
        $random->fillBoard($board, $options->createOpt());
        foreach ($board->board as $item)
        {
            foreach ($item as $val)
            {
                $this->assertEquals(true, $val->isAlive()); //must set $percent = 100 in RandomInput.php to pass
            }
            $this->assertEquals($board->height, count($item));
        }
        $this->assertNotEmpty($random);
        unset($GLOBALS["__user_unit_test"]);
    }

    function testAddOptions()
    {
        $options = new GetOptMock();
        $random = new RandomInput();
        $random->addOptions($options->createOpt());
        $this->assertNotEmpty($random);
    }
}
