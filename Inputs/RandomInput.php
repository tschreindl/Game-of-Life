<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

namespace Input;

use GameOfLife\Board;
use UlrichSG\GetOpt;

/**
 * Input Class for a Random generation
 *
 * @package GameOfLife\Inputs
 */
class RandomInput extends BaseInput
{
    /**
     * Fills the board with a random generation
     *
     * @param Board $_board
     * @param GetOpt $_options
     */
    function fillBoard(Board $_board, GetOpt $_options)
    {
        $percent = rand(20, 80);
        $fillingLVL = $_options->getOption("fillingLVL");
        if ($fillingLVL != null)
        {
            if ($fillingLVL < 1 || $fillingLVL > 100)
            {
                echo "Der Wert darf nur zwischen 1 und 100 liegen\n";
                echo "Zufälligen Füllungsgrad von " . $percent . " % ausgewählt\n";
            }
            else
            {
                $percent = $fillingLVL;
                echo "Füllgrad von ~" . $percent . "%\n";
            }
        }

        if (isset($GLOBALS["__user_unit_test"])) $percent = 100; //only for unit test

        for ($x = 0; $x < $_board->width; $x++)
        {
            for ($y = 0; $y < $_board->height; $y++)
            {
                $rand = rand(1, 100);
                if ($rand <= $percent) $_board->setField($x, $y, true);
                if ($rand > $percent) $_board->setField($x, $y, false);
            }
        }
    }

    /**
     * Add available options
     *
     * available options:
     *-fillingLVL
     *
     * @param GetOpt $_options
     */
    function addOptions(GetOpt $_options)
    {
        $_options->addOptions(array(
            array(null, "fillingLVL", GetOpt::REQUIRED_ARGUMENT, "RandomInput - Füllgrad der Lebenden Zellen in Prozent. Standard: 20-80%\n")
        ));
    }
}