<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

use GameOfLife\Board;
use Rule\StandardRule;
use PHPUnit\Framework\TestCase;

/**
 * Class StandardRuleTest
 */
class StandardRuleTest extends TestCase
{
    function testCalculateNewState()
    {
        $board = new Board(10, 10);
        $rule = new StandardRule();
        $board->setField(1, 2, true);
        $board->setField(2, 2, true);
        $board->setField(3, 2, true);

        $this->assertFalse($rule->calculateNewState($board->board[2][1]));
        $this->assertFalse($rule->calculateNewState($board->board[2][3]));
        $this->assertTrue($rule->calculateNewState($board->board[1][2]));
        $this->assertTrue($rule->calculateNewState($board->board[2][2]));
        $this->assertTrue($rule->calculateNewState($board->board[3][2]));
    }
}
