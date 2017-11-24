<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

namespace Output;

use GameOfLife\Board;
use GameOfLife\Field;
use UlrichSG\GetOpt;

/**
 * Output Class to Output the Board in PHP/Terminal.
 *
 * @package Output
 */
class ConsoleOutput extends BaseOutput
{
    private $generation = 0;
    private $echo1 = "─────┐\n";
    private $echo2 = "─────┘\n";

    /**
     * Runs before the Board Output starts.
     *
     * @param GetOpt $_options
     */
    function startOutput(GetOpt $_options)
    {
        echo "Ausgabe in Konsole erfolgt...\n";
    }

    /**
     * Prints the current Board in PHP/Terminal.
     *
     * @param Board $_board
     * @param GetOpt $_options
     */
    function outputBoard(Board $_board, GetOpt $_options)
    {
        if ($_options->getOption("cmd") != null)
        {
            $this->echo1 = "┐\n";
            $this->echo2 = "┘\n";
        }

        echo "Aktuelle Generation: ";
        echo $this->generation;
        echo "\n";
        $this->generation++;

        echo "┌";
        for ($strokes = 1; $strokes <= $_board->width(); $strokes++)
        {
            echo "───";
        }
        echo $this->echo1;


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
        echo $this->echo2;
    }

    /**
     * Add available options.
     *
     * available options:
     * -cmd
     *
     * @param GetOpt $_options
     */
    function addOptions(GetOpt $_options)
    {
        $_options->addOptions(array(
            array(null, "cmd", GetOpt::NO_ARGUMENT, "ConsoleOutput - Wenn die Ausgabe per CMD Fenster oder Terminal erfolgt.\n")
        ));
    }
}