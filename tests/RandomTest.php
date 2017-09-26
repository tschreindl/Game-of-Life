<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../Inputs/Random.php";
require_once __DIR__ . "/../Board.php";
require_once "GetOptMock.php";

/**
 * Class RandomTest
 */
class RandomTest extends TestCase
{
    function testFillBoard()
    {
        $board = new \GameOfLife\Board(30,20);
        $board->initEmpty();
        $random = new \Input\Random();
        $options = new  GetOptMock();
        $random->fillBoard($board, $options->createOpt());
            foreach ($board->board as $item)
            {
                foreach ($item as $val)
                {
                    $this->assertEquals(true, $val); //must set $percent = 100 in Random.php to pass
                }
                $this->assertEquals($board->height, count($item));
            }
        $this->assertNotEmpty($random);
    }

    function testAddOptions()
    {
        $options = new GetOptMock();
        $random = new \Input\Random();
        $random->addOptions($options->createOpt());
        $this->assertNotEmpty($random);
    }
}
