<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

namespace GameOfLife;

/**
 * Class Field
 *
 * @package GameOfLife
 */
class Field
{
    private $board;
    private $isAlive;
    private $x;
    private $y;

    public function __construct(Board $_board, int $_x, int $_y)
    {
        $this->board = $_board;
        $this->x = $_x;
        $this->y = $_y;
        $this->setValue(false);
    }

    /**
     * Sets the actual field to alive oder dead (true oder false).
     *
     * @param bool $_value
     */
    public function setValue(bool $_value)
    {
        $this->isAlive = $_value;
    }

    /**
     * Returns the current state of the Field (alive = true, dead = false).
     *
     * @return bool
     */
    public function isAlive()
    {
        if ($this->isAlive === true)
        {
            return true;
        }
        return false;
    }

    /**
     * Returns the x position of the field.
     *
     * @return int
     */
    public function x()
    {
        return $this->x;
    }

    /**
     * Returns the y position of the field.
     *
     * @return int
     */
    public function y()
    {
        return $this->y;
    }

    /**
     * Returns the living neighbours around the field.
     *
     * @return int
     */
    public function livingNeighbours()
    {
        $aliveNeighbours = 0;
        for ($x = $this->x - 1; $x <= $this->x + 1; $x++)
        {
            for ($y = $this->y - 1; $y <= $this->y + 1; $y++)
            {
                if ($y >= 0 && $y < $this->board->height && $x >= 0 && $x < $this->board->width)
                {
                    if ($x !== $this->x || $y !== $this->y)
                    {
                        if ($this->board->board[$y][$x]->isAlive() === true)
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
     * Returns the dead neighbours around the field.
     *
     * @return int
     */
    public function deadNeighbours()
    {
        $deadNeighbours = 0;
        for ($x = $this->x - 1; $x <= $this->x + 1; $x++)
        {
            for ($y = $this->y - 1; $y <= $this->y + 1; $y++)
            {
                if ($y >= 0 && $y < $this->board->height && $x >= 0 && $x < $this->board->width)
                {
                    if ($x !== $this->x || $y !== $this->y)
                    {
                        if ($this->board->board[$x][$y]->isAlive() === false)
                        {
                            $deadNeighbours++;
                        }
                    }
                }
            }
        }
        return $deadNeighbours;
    }
}