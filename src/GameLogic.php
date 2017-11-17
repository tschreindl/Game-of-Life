<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

namespace GameOfLife;
use Rule\BaseRule;

/**
 * Class GameLogic
 *
 * @package GameOfLife
 */
class GameLogic
{
    private $rule;
    private $historyOfBoards = array();

    public function __construct(BaseRule $_rule)
    {
        $this->rule = $_rule;
    }

    /**
     * Calculates the next Board based on the previous Board.
     *
     * @param Board $_board
     * @return Board
     */
    public function calculateNextBoard(Board $_board)
    {
        $this->historyOfBoards[] = $this->generateString($_board);
        $nextBoard = $_board->initEmpty();
        for ($y = 0; $y < $_board->height; $y++)
        {
            for ($x = 0; $x < $_board->width; $x++)
            {
                $nextBoard[$x][$y]->setValue($this->rule->calculateNewState($_board->board[$x][$y]));
            }
        }
        $_board->board = $nextBoard;
    }

    /**
     * Generates a string based on the living and dead cells from the given Board.
     * The string is needed to check if there is no further generation.
     * The string contains 0 and 1.
     *
     * @param Board $_board
     * @return string
     */
    private function generateString(Board $_board)
    {
        $addString = "";
        for ($y = 0; $y < $_board->height; $y++)
        {
            for ($x = 0; $x < $_board->width; $x++)
            {
                if ($_board->board[$x][$y]->isAlive() == false)
                {
                    $addString .= "0";
                }
                else if ($_board->board[$x][$y]->isAlive() == true)
                {
                    $addString .= "1";
                }
            }
        }
        return $addString;
    }

    /**
     * Checks each past generation to prevent there is a repeating generation and the game runs endless.
     *
     * @param Board $_board
     * @return bool
     */
    public function isLoopDetected(Board $_board)
    {
        foreach ($this->historyOfBoards as $oldBoard)
        {
            if ($this->generateString($_board) == $oldBoard)
            {
                echo "\nKeine weiteren Generationen mehr oder wiederholende Generationen!\n";
                return true;
            }
        }
    }
}