<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

use GameOfLife\Field;
use PHPUnit\Framework\TestCase;

/**
 * Class FieldTest
 */
class FieldTest extends TestCase
{

    function testSetValue()
    {
        $board = new \GameOfLife\Board(10, 10);
        $field = new Field($board, 1, 1);
        $field->setValue(true);
        $this->assertTrue($field->isAlive());
    }

    function testIsAlive()
    {
        $board = new \GameOfLife\Board(10, 10);
        $field = new Field($board, 1, 1);
        $field->setValue(false);
        $this->assertFalse($field->isAlive());
    }

    function testX()
    {
        $board = new \GameOfLife\Board(10, 10);
        $field = new Field($board, 1, 1);
        $this->assertEquals(1, $field->x());
    }

    function testY()
    {
        $board = new \GameOfLife\Board(10, 10);
        $field = new Field($board, 1, 1);
        $this->assertEquals(1, $field->y());
    }

    function testLivingNeighbours()
    {
        $board = new \GameOfLife\Board(10, 10);
        $board->board[1][1]->setValue(true);
        $board->board[2][1]->setValue(true);
        $board->board[1][2]->setValue(true);
        $board->board[2][2]->setValue(true);
        $this->assertEquals(3, $board->board[2][2]->livingNeighbours());
    }

    function testDeadNeighbours()
    {
        $board = new \GameOfLife\Board(10, 10);
        $board->board[1][1]->setValue(true);
        $board->board[2][1]->setValue(true);
        $board->board[1][2]->setValue(true);
        $board->board[2][2]->setValue(true);
        $this->assertEquals(5, $board->board[2][2]->deadNeighbours());
    }
}
