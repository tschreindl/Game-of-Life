<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

namespace Output;

use GameOfLife\Board;
use UlrichSG\GetOpt;


/**
 * Class ConsoleOutput
 *
 * @package Output
 */
class ConsoleOutput extends BaseOutput
{
    private $generation = 0;
    private $echo1 = "─────┐\n";
    private $echo2 = "─────┘\n";

    function startOutput($_options)
    {
        echo "Ausgabe in Konsole erfolgt...\n";
    }

    /**
     * @param Board $_board
     * @param GetOpt $_options
     */
    function outputBoard($_board, $_options)
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
        for ($strokes = 1; $strokes <= $_board->width; $strokes++)
        {
            echo "───";
        }
        echo $this->echo1;

        for ($y = 0; $y < $_board->height; $y++)
        {
            echo "│";
            for ($x = 0; $x < $_board->width; $x++)
            {

                if ($_board->board[$x][$y] == false)
                {
                    echo "   ";
                }
                elseif ($_board->board[$x][$y] == true)
                {
                    echo " ¤ ";
                }
            }
            echo "│\n";
        }

        echo "└";
        for ($strokes = 1; $strokes <= $_board->width; $strokes++)
        {
            echo "───";
        }
        echo $this->echo2;
    }

    /**
     * @param GetOpt $_options
     */
    function addOptions($_options)
    {
        $_options->addOptions(array(
            array(null, "cmd", GetOpt::NO_ARGUMENT, "Wenn die Ausgabe per CMD Fenster oder Terminal erfolgt.")
        ));
    }
}