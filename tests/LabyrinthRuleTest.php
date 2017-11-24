<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

use GameOfLife\Board;
use Rule\LabyrinthRule;
use PHPUnit\Framework\TestCase;

/**
 * Class LabyrinthRuleTest
 */
class LabyrinthRuleTest extends TestCase
{
    function testCalculateNewState()
    {
        $board = new Board(10, 10);
        $rule = new LabyrinthRule();
        $board->setField(4, 4, true);
        $board->setField(5, 4, true);
        $board->setField(6, 4, true);
        $board->setField(4, 5, true);
        $board->setField(5, 5, true);
        $board->setField(6, 5, true);

        $this->assertTrue($rule->calculateNewState($board->board[4][4]));
        $this->assertTrue($rule->calculateNewState($board->board[4][5]));
        $this->assertTrue($rule->calculateNewState($board->board[4][6]));
        $this->assertTrue($rule->calculateNewState($board->board[5][4]));
        $this->assertTrue($rule->calculateNewState($board->board[5][5]));
        $this->assertTrue($rule->calculateNewState($board->board[5][6]));
        $this->assertTrue($rule->calculateNewState($board->board[3][5]));
        $this->assertTrue($rule->calculateNewState($board->board[6][5]));
    }
}
