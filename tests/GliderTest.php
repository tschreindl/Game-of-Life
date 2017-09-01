<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../Inputs/Glider.php";
require_once __DIR__ . "/../Board.php";
require_once "GetOptMock.php";

/**
 * Class GliderTest
 */
class GliderTest extends TestCase
{
    function testFillBoard()
    {
        $count = 0;
        $board = new \GameOfLife\Board(30,20);
        $board->initEmpty();
        $random = new \Input\Glider();
        $options = new  GetOptMock();
        $random->fillBoard($board, $options->createOpt());
        foreach ($board->board as $item)
        {
            foreach ($item as $val)
            {
                if ($val == true) $count++;
                //$this->assertEquals(true, $val); //must set $percent = 100 in Random.php to pass
            }
            $this->assertEquals($board->height, count($item));
        }
        $this->assertEquals(5, $count);
        $this->assertNotEmpty($random);
    }
}
