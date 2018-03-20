<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Yannick Lapp <yannick.lapp@cn-consult.eu>
 */

namespace Input;

use GameOfLife\Field;
use GameOfLife\Board;
use Ulrichsg\Getopt;

/**
 * Input Class to let the user input which cells are alive.
 *
 * @package Input
 */
class UserInput extends BaseInput
{
    /**
     * Fills the board with cells that the user inputs.
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
            $this->print($_board);

            // command prompt
            echo "\nGib die Koordinaten der Zelle ein die gesetzt/zurückgesetzt werden soll";
            echo "\nGib 's' oder 'start' ein um die Simulation zu starten\n\n";


            //This is an ugly hack to make unit-tests work. Please bear with it! :-)
            if (isset($GLOBALS["__user_unit_test"])) break;

            $inputX = readline("X:");

            if ($inputX == "s" || $inputX == "start") $inputEnd = true;
            else
            {
                $inputX = intval($inputX);

                if ($inputX - 1 < 0 || $inputX - 1 >= $_board->width())
                {
                    echo "\nFehler: X Koordinate muss zwischen 1 und " . $_board->width() . " sein\n\n";
                }
                else
                {
                    $inputY = readline("Y:");

                    if ($inputY == "s" || $inputY == "start") $inputEnd = true;
                    else
                    {
                        $inputY = intval($inputY);

                        if ($inputY - 1 < 0 || $inputY - 1 >= $_board->height())
                        {
                            echo "\nFehler: Y Koordinate muss zwischen 1 und " . $_board->height() . " sein\n\n";
                        }
                        else
                        {
                            /** @var Field $field */
                            $field = $_board->board[$inputY - 1][$inputX - 1];
                            $currentCellState = $field->isAlive();

                            $_board->setField($inputX - 1, $inputY - 1, !$currentCellState);

                            echo "Zelle auf (" . $inputX . "|" . $inputY . ") ";
                            if ($currentCellState == true) echo "zurückgesetzt";
                            else echo "gesetzt";
                            echo "\n\n";

                        }
                    }
                }
            }
        }
    }

    /**
     * Prints the current Board to PHP/Console.
     * Only needed for this Class.
     *
     * @param Board $_board
     */
    public function print(Board $_board)
    {
        echo "┌";
        for ($strokes = 1; $strokes <= $_board->width(); $strokes++)
        {
            echo "───";
        }
        echo "┐\n";


        foreach ($_board->board as $line)
        {
            echo "│";
            foreach ($line as $field)
            {
                /** @var Field $field */
                if ($field->isAlive() == false)
                {
                    echo "   ";
                }
                elseif ($field->isAlive() == true)
                {
                    echo " ¤ ";
                }
            }
            echo "│\n";
        }

        echo "└";
        for ($strokes = 1; $strokes <= $_board->width(); $strokes++)
        {
            echo "───";
        }
        echo "┘\n";
    }
}