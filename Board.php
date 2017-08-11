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

    }

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

    function initRider()
    {
        $this->setField(1, 0, true);
        $this->setField(2, 1, true);
        $this->setField(0, 2, true);
        $this->setField(1, 2, true);
        $this->setField(2, 2, true);
    }

    //function init

    function setField($_x,$_y,$_value)
    {
        $this->board[$_x][$_y]=$_value;
    }


    /**
     * @return Board
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