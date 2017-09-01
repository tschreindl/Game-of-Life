<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../Board.php";

/**
 * Class BoardTest
 */
class BoardTest extends TestCase
{
    protected $width = 30;
    protected $height = 20;
    protected $x = 2;
    protected $y = 5;

    function testInitEmpty()
    {
        $board = new \GameOfLife\Board($this->width, $this->height);
        $this->assertEquals($this->width*$this->height, count($board->initEmpty(), COUNT_RECURSIVE) -$this->width);
        foreach ($board->initEmpty() as $item)
        {
            foreach ($item as $val)
            {
             $this->assertEquals(false, $val);
            }
            $this->assertEquals($this->height, count($item));
        }
        $this->assertNotEmpty($board->initEmpty());
    }

    function testSetField()
    {
        $value = true;
        $board = new \GameOfLife\Board($this->width, $this->height);
        $board->setField($this->x,$this->y, $value);
        $this->assertEquals($value, $board->board[$this->x][$this->y]);
    }

    function testCalculateNextStep()
    {
        $board = new \GameOfLife\Board($this->width, $this->height);
        $board->setField(1,1, true);
        $board->setField(2,1, true);
        $board->setField(3,1, true);
        $oldBoard = $board->board;
        $board->calculateNextStep();
        $this->assertNotEquals($oldBoard, $board->board);
        $this->assertEquals($this->width*$this->height, count($board->board, COUNT_RECURSIVE) - $this->width);
    }

    function testCheckNeighbours()
    {
        $board = new \GameOfLife\Board($this->width, $this->height);

        $this->assertEquals(0, $board->checkNeighbour($this->x, $this->y));
    }

    function testIsFinished()
    {
        $board = new \GameOfLife\Board($this->width, $this->height);
        $board->initEmpty();
        $board->calculateNextStep();
        $this->assertTrue($board->isFinished());
        $this->expectOutputString("\nKeine weiteren Generationen mehr oder wiederholende Generationen!\n");
    }
}
