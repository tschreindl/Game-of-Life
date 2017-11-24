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
    private $width;
    private $height;

    /** @var array|Field[][] */
    public $board = array();

    function __construct($_width, $_height)
    {
        $this->height = $_height;
        $this->width = $_width;
        $this->board = $this->initEmpty();
    }

    /**
     * Creates a new Field object for each field and set it so false(dead).
     *
     * @return Field[][]
     */
    public function initEmpty()
    {
        $newBoard = array();
        for ($y = 0; $y < $this->height; $y++)
        {
            for ($x = 0; $x < $this->width; $x++)
            {
                $newBoard[$y][$x] = new Field($this, $x, $y);
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
    function setField(int $_x, int $_y, bool $_value)
    {
        if (isset($this->board[$_y][$_x])) $this->board[$_y][$_x]->setValue($_value);
    }

    /**
     * Returns the living neighbours of the given field.
     *
     * @param Field $_field
     * @return int Number of living Neighbours
     */
    function neighborsOfField(Field $_field)
    {
        return $_field->livingNeighbours();
    }

    /**
     * Returns the width of the current board.
     *
     * @return mixed
     */
    public function width()
    {
        return $this->width;
    }

    /**
     * Returns the height of the current board.
     *
     * @return mixed
     */
    public function height()
    {
        return $this->height;
    }
}