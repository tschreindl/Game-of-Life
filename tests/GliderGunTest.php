<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../Inputs/GliderGun.php";
require_once __DIR__ . "/../Board.php";
require_once "GetOptMock.php";

/**
 * Class GliderGunTest
 */
class GliderGunTest extends TestCase
{
    function testFillBoard()
    {
        $count = 0;
        $falseCount = 0;

        $board = new \GameOfLife\Board(40,40);
        $board->initEmpty();
        $gliderGun = new \Input\GliderGun();
        $options = new  GetOptMock();
        $gliderGun->fillBoard($board, $options->createOpt());
        foreach ($board->board as $items)
        {
            foreach ($items as $item)
            {
                if ($item == true)
                {
                    $count++;
                    $this->assertTrue($item);
                }
                if ($item == false)
                {
                    $falseCount++;
                    $this->assertFalse($item);
                }
            }
            $this->assertEquals($board->height, count($items));
        }
        $this->assertEquals(36, $count);
        $this->assertEquals($board->width*$board->height-36, $falseCount);
        $this->assertNotEmpty($gliderGun);
    }

    function testAddOptions()
    {
        $options = new GetOptMock();
        $gliderGun = new \Input\GliderGun();
        $gliderGun->addOptions($options->createOpt());
        $this->assertNotEmpty($gliderGun);
    }
}
