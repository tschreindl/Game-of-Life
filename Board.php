<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

/**
 * Represents a game of life game board.
 */
class Board
{
    private $width;
    private $height;
    private $board=array();

    function __construct($_width, $_height)
    {
        $this->height=$_height;
        $this->width=$_width;
        $this->initEmpty();

        //$this->setField("test",2,5);

        //$this->setField(4,"a",true);

    }


    /**
     * Initialize an empty field.
     * Sets every entry of "array" board to false.
     */
    private function initEmpty()
    {
        for ($x=0; $x < $this->width; $x++)
        {
            $this->board[$x]=array();
            for ($y=0; $y<$this->height; $y++)
            {
                $this->board[$x][$y]=false;
            }
        }
    }


    /**
     * Initialize a random generation on the field
     * Sets random entries of array "board" to true.
     */
    function initRandom()
    {
        for ($x=0; $x < $this->width; $x++)
        {
            for ($y=0; $y<$this->height; $y++)
            {
                $rand=rand(0,1);
                if ($rand==1) $this->board[$x][$y]=true;
            }
        }
    }

    /**
     * Initialize a generation called "Rider".
     * Calls the function setField to sets different
     * entries to true, to initialize the "Rider".
     */
    function initRider()
    {
        $this->setField(1, 0, true);
        $this->setField(2, 1, true);
        $this->setField(0, 2, true);
        $this->setField(1, 2, true);
        $this->setField(2, 2, true);
    }

    /**
     * Initialize a generation that is not named.
     * Calls the function setField to sets different
     * entries to true, to initialize a special generation
     * that will disappear after 54 generations.
     */
    function initSpecial()
    {
        $this->setField(0, 0, true);
        $this->setField(1, 0, true);
        $this->setField(2, 0, true);
        $this->setField(0, 1, true);
        $this->setField(0, 2, true);
        $this->setField(2, 1, true);
        $this->setField(2, 2, true);
        $this->setField(0, 4, true);
        $this->setField(0, 5, true);
        $this->setField(0, 6, true);
        $this->setField(2, 4, true);
        $this->setField(2, 5, true);
        $this->setField(2, 6, true);
        $this->setField(1, 6, true);
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
        $this->board[$_x][$_y]=$_value;
    }


    /**
     * Calculates the next generation
     * @return Board The board of the calculated next step.
     */
    function calculateNextStep()
    {
        $nextBoard=new Board($this->width,$this->height);

        for ($y=0; $y < count($this->board); $y++)
        {
            for ($x=0; $x<count($this->board[$y]); $x++)
            {
                $numAliveNeighbors=$this->checkNeighbour($x,$y);
                $currentCellState = $this->board[$x][$y];
                $newCellState = $currentCellState;
                if ($this->board[$x][$y] === false && $numAliveNeighbors == 3)
                {
                    $newCellState = true;
                }elseif ($this->board[$x][$y] === true && $numAliveNeighbors < 2)
                {
                    $newCellState = false;
                }
                elseif ($this->board[$x][$y] === true && $numAliveNeighbors > 3)
                {
                   $newCellState = false;
                }
                $nextBoard->setField($x,$y,$newCellState);
            }

        }

        for ($strokes = 1; $strokes <= $this->width; $strokes++)
        {
            echo " - ";
        }
        echo "\n";
        return $nextBoard;
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
        for ($x = $_x-1; $x <= $_x+1; $x++)
        {
            for ($y = $_y-1; $y <= $_y+1; $y++)
            {
                if ($y>=0 && $y<$this->height && $x>=0 && $x<$this->width)
                {
                    if ($x==$_x && $y==$_y)
                    {

                    }
                    else
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
     * Prints the next field out with echo
     */
    function print()
    {
        for ($y=0; $y < count($this->board); $y++)
        {
            for ($x=0; $x<count($this->board[$y]); $x++)
            {
                if ($this->board[$x][$y] === false)
                {
                    echo " ";
                } elseif ($this->board[$x][$y] === true)
                {
                    echo "x";
                }
                else echo $this->board[$x][$y];
                echo "  ";
            }
            echo "\n";
        }
    }


}