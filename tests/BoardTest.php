<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

use GameOfLife\Board;
use GameOfLife\Field;
use PHPUnit\Framework\TestCase;

/**
 * Tests that the class Board works as expected.
 */
class BoardTest extends TestCase
{
    protected $width = 10;
    protected $height = 10;
    protected $x = 2;
    protected $y = 5;

    function testInitEmpty()
    {
        $board = new Board($this->width, $this->height);
        $this->assertEquals($this->width * $this->height, count($board->initEmpty(), COUNT_RECURSIVE) - $this->width);
        foreach ($board->board as $line)
        {
            foreach ($line as $field)
            {
                /** @var Field $field */
                $this->assertEquals(false, $field->isAlive());
            }
            $this->assertEquals($this->height, count($line));
        }
        $this->assertNotEmpty($board->initEmpty());

        $this->assertClassHasAttribute("height", Board::class);
        $this->assertClassHasAttribute("width", Board::class);
        $this->assertClassHasAttribute("board", Board::class);
    }

    function testSetField()
    {
        $value = true;
        $board = new Board($this->width, $this->height);
        $board->setField($this->x, $this->y, $value);
        $this->assertEquals($value, $board->board[$this->x][$this->y]->isAlive());
    }

    function testCheckNeighbours()
    {
        $board = new Board($this->width, $this->height);

        $this->assertEquals(0, $board->neighborsOfField($board->board[0][0]));
        $board->setField(1, 1, true);
        $board->setField(2, 1, true);
        $board->setField(3, 1, true);
        $this->assertEquals(2, $board->neighborsOfField($board->board[2][1]));
    }

}
