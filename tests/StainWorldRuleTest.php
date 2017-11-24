<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

use GameOfLife\Board;
use Rule\StainWorldRule;
use PHPUnit\Framework\TestCase;

/**
 * Class StainWorldRuleTest
 */
class StainWorldRuleTest extends TestCase
{
    function testCalculateNewState()
    {
        $board = new Board(10, 10);
        $rule = new StainWorldRule();
        $board->setField(4, 4, true);

        foreach ($board->board as $line)
        {
            foreach ($line as $field)
            {
                /** @var \GameOfLife\Field $field */
                $this->assertTrue($rule->calculateNewState($field));
            }
        }
    }
}
