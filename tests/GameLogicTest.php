<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

use GameOfLife\Board;
use GameOfLife\GameLogic;
use PHPUnit\Framework\TestCase;
use Rule\StandardRule;

/**
 * Class GameLogicTest
 */
class GameLogicTest extends TestCase
{
    function testCalculateNextBoard()
    {
        $board = new Board(5, 5);
        $rule = new StandardRule();
        $gameLogic = new GameLogic($rule);
        $board->setField(1, 2, true);
        $board->setField(2, 2, true);
        $board->setField(3, 2, true);
        $gameLogic->calculateNextBoard($board);

        $this->assertTrue($board->board[1][2]->isAlive());
        $this->assertTrue($board->board[2][2]->isAlive());
        $this->assertTrue($board->board[3][2]->isAlive());
        $this->assertFalse($board->board[2][1]->isAlive());
        $this->assertFalse($board->board[2][3]->isAlive());
    }

    function testIsLoopDetected()
    {
        $board = new Board(5, 5);
        $rule = new StandardRule();
        $gameLogic = new GameLogic($rule);
        $board->setField(1, 1, true);
        $board->setField(2, 1, true);
        $board->setField(1, 2, true);
        $board->setField(2, 2, true);
        $gameLogic->calculateNextBoard($board);
        $this->assertTrue($gameLogic->isLoopDetected($board));
    }
}
