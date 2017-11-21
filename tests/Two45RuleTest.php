<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

use GameOfLife\Board;
use Rule\Two45Rule;
use PHPUnit\Framework\TestCase;

/**
 * Class Two45RuleTest
 */
class Two45RuleTest extends TestCase
{
    function testCalculateNewState()
    {
        $board = new Board(10, 10);
        $rule = new Two45Rule();
        $board->setField(5, 4, true);
        $board->setField(6, 4, true);
        $board->setField(7, 4, true);
        $board->setField(5, 5, true);
        $board->setField(6, 5, true);
        $board->setField(7, 5, true);

        $this->assertFalse($rule->calculateNewState($board->board[4][5]));
        $this->assertFalse($rule->calculateNewState($board->board[4][7]));
        $this->assertFalse($rule->calculateNewState($board->board[5][5]));
        $this->assertFalse($rule->calculateNewState($board->board[5][7]));

        $this->assertTrue($rule->calculateNewState($board->board[3][6]));
        $this->assertTrue($rule->calculateNewState($board->board[4][6]));
        $this->assertTrue($rule->calculateNewState($board->board[5][6]));
        $this->assertTrue($rule->calculateNewState($board->board[6][6]));
    }
}
