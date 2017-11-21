<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

use GameOfLife\Board;
use Rule\CopyRule;
use PHPUnit\Framework\TestCase;

/**
 * Class CopyRuleTest
 */
class CopyRuleTest extends TestCase
{
    function testCalculateNewState()
    {
        $board = new Board(10, 10);
        $rule = new CopyRule();
        $board->setField(5, 5, true);
        $board->setField(5, 6, true);
        $board->setField(6, 5, true);
        $board->setField(6, 6, true);

        $this->assertTrue($rule->calculateNewState($board->board[4][4]));
        $this->assertTrue($rule->calculateNewState($board->board[4][7]));
        $this->assertTrue($rule->calculateNewState($board->board[7][4]));
        $this->assertTrue($rule->calculateNewState($board->board[7][7]));
    }
}
