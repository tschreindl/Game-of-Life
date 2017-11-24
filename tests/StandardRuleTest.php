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

require_once "GetOptMock.php";

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

    function testSetField()
    {
        $board = new Board(10, 10);
        $rule = new StandardRule();
        $rule->setRule("245/3");
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

    function testAddOptions()
    {
        $options = new GetOptMock();
        $rule = new StandardRule();
        $rule->addOptions($options->createOpt());
        $this->assertNotEmpty($rule);
    }
}
