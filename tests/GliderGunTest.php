<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

use GameOfLife\Board;
use Input\GliderGun;
use PHPUnit\Framework\TestCase;

require_once "GetOptMock.php";

/**
 * Tests that the class GliderGun works as expected.
 */
class GliderGunTest extends TestCase
{
    function testFillBoard()
    {
        $count = 0;
        $falseCount = 0;

        $board = new Board(40, 40);
        $board->initEmpty();
        $gliderGun = new GliderGun();
        $options = new  GetOptMock();
        $gliderGun->fillBoard($board, $options->createOpt());
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
        $this->assertEquals(36, $count);
        $this->assertEquals($board->width * $board->height - 36, $falseCount);
        $this->assertNotEmpty($gliderGun);
    }

    function testAddOptions()
    {
        $options = new GetOptMock();
        $gliderGun = new GliderGun();
        $gliderGun->addOptions($options->createOpt());
        $this->assertNotEmpty($gliderGun);
    }
}
