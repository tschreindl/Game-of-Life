<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

namespace GameOfLife;

/**
 * Represents a game of life game board.
 */
class Board
{
    public $width;
    public $height;
    public $board = array();
    private $historyOfBoards = array();
    private $curGameStep = 0;

    function __construct($_width, $_height)
    {
        $this->height = $_height;
        $this->width = $_width;
        $this->board = $this->initEmpty();
    }

    /**
     * Initialize an empty field.
     * Sets every entry of "array" board to false.
     */
    private function initEmpty()
    {
        $newBoard = array();
        for ($y = 0; $y < $this->height; $y++)
        {
            for ($x = 0; $x < $this->width; $x++)
            {
                $newBoard[$x][$y] = false;
            }
        }
        return $newBoard;
    }

    /**
     * Sets the value of a field.
     *
     * \b Note: The x- and y-values are 0-index
     *
     * @param int $_x The x-coordinate of the field that should be set.
     * @param int $_y The y-coordinate of the field that should be set.
     * @param bool $_value The value the field should have.
     */
    function setField(int $_x, int $_y, $_value)
    {
        $this->board[$_x][$_y] = $_value;
    }

    /**
     * Calculates the next generation
     */
    function calculateNextStep()
    {
        $this->curGameStep++;
        $this->historyOfBoards[] = $this->board;
        $nextBoard = $this->initEmpty();
        for ($y = 0; $y < $this->height; $y++)
        {
            for ($x = 0; $x < $this->width; $x++)
            {
                $numAliveNeighbors = $this->checkNeighbour($x, $y);
                $currentCellState = $this->board[$x][$y];
                $newCellState = $currentCellState;
                if ($this->board[$x][$y] == false && $numAliveNeighbors == 3)
                {
                    $newCellState = true;
                }
                else if ($this->board[$x][$y] == true && $numAliveNeighbors < 2)
                {
                    $newCellState = false;
                }
                elseif ($this->board[$x][$y] == true && $numAliveNeighbors > 3)
                {
                    $newCellState = false;
                }
                $nextBoard[$x][$y] = $newCellState;
            }
        }
        $this->board = $nextBoard;
    }

    /**
     * Checks how many neighbours are alive
     *
     * \b Note: $_x and $_y must type int and 0 indexed
     *
     * @param int $_x
     * @param int $_y
     * @return int $aliveNeighbours
     */
    private function checkNeighbour($_x, $_y)
    {
        $aliveNeighbours = 0;
        for ($x = $_x - 1; $x <= $_x + 1; $x++)
        {
            for ($y = $_y - 1; $y <= $_y + 1; $y++)
            {
                if ($y >= 0 && $y < $this->height && $x >= 0 && $x < $this->width)
                {
                    if ($x !== $_x || $y !== $_y)
                    {
                        if ($this->board[$x][$y] === true)
                        {
                            $aliveNeighbours++;
                        }
                    }
                }
            }
        }
        return $aliveNeighbours;
    }

    /**
     * Checks if there is no further generation
     * var futureGenerations calculates x times to the
     * future to catch repeating generations
     *
     * @return bool
     */
    function isFinished()
    {
        foreach ($this->historyOfBoards as $oldBoard)
        {
            if ($this->board == $oldBoard)
            {
                echo "\nKeine weiteren Generationen mehr oder wiederholende Generationen!\n";
                return true;
            }
        }
        return false;
    }
}