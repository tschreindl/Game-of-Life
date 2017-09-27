<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Yannick Lapp <yannick.lapp@cn-consult.eu>
 */

namespace Input;

use UlrichSG\Getopt;
use GameOfLife\Board;

/**
 * Input Class to let the user input which cells are alive
 *
 * @package Input
 */
class User extends BaseInput
{
    /**
     * Fills the board with cells that the user inputs
     *
     * @param Board $_board The Board
     * @param GetOpt $_options All options (including input specific options)
     */
    public function fillBoard(Board $_board, GetOpt $_options)
    {
        // indicates whether the user finished setting cells
        $inputEnd = false;

        // input loop
        while ($inputEnd == false)
        {
            // Print current board
            for ($strokes = 1; $strokes <= $_board->width; $strokes++)
            {
                echo "---";
            }
            echo "\n";

            $this->print($_board);

            // command prompt
            echo "\nEnter the coordinates of the cell that you want to set/unset";
            echo "\nEnter 's' or 'start' to start the simulation\n\n";


            //This is an ugly hack to make unit-tests work. Pleaes bear with it! :-)
            if (isset($GLOBALS["__user_unit_test"])) break;


            $inputX = readline("X:");

            if ($inputX == "s" || $inputX == "start") $inputEnd = true;
            else
            {
                $inputX = intval($inputX);

                if ($inputX - 1 < 0 || $inputX - 1 >= $_board->width)
                {
                    echo "\nError: X Coordinate must be between 1 and " . $_board->width . "\n\n";
                }
                else
                {
                    $inputY = readline("Y:");

                    if ($inputY == "s" || $inputX == "start") $inputEnd = true;
                    else
                    {
                        $inputY = intval($inputY);

                        if ($inputY - 1 < 0 || $inputY - 1 >= $_board->height)
                        {
                            echo "\nError: Y Coordinate must be between 1 and " . $_board->height . "\n\n";
                        }
                        else
                        {
                            $currentCellState = $_board->board[$inputX - 1][$inputY - 1];

                            $_board->setField($inputX - 1, $inputY - 1, !$currentCellState);

                            echo "Successfully ";
                            if ($currentCellState == true) echo "unset ";
                            else echo "set ";
                            echo "the cell at (" . $inputX . "|" . $inputY . ")!\n\n";
                        }
                    }
                }
            }
        }
    }

    /**
     * Adds UserInput specific options to the option list
     *
     * @param GetOpt $_options Options to which the input specific options are added
     */
    public function addOptions(GetOpt $_options)
    {
    }

    /**
     * Prints the current Board to PHP/Console
     * Only needed for this Class/Input
     *
     * @param $_board
     */
    public function print(Board $_board)
    {
        for ($y = 0; $y < $_board->height; $y++)
        {
            for ($x = 0; $x < $_board->width; $x++)
            {
                if ($_board->board[$x][$y] == false)
                {
                    echo "   ";
                }
                elseif ($_board->board[$x][$y] == true)
                {
                    echo " x ";
                }
            }
            echo "|\n";
        }

        for ($strokes = 1; $strokes <= $_board->width; $strokes++)
        {
            echo "---";
        }
        echo "\n";
    }
}