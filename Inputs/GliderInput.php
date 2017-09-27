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
 * Input Class for a generation called "Glider"
 *
 * @package GameOfLife\Inputs
 */
class GliderInput extends BaseInput
{
    /**
     * Fills the board with a generation called Glider
     *
     * @param Board $_board
     * @param GetOpt $_options
     */
    function fillBoard(Board $_board, GetOpt $_options)
    {
        $posX = round(($_board->width - 3) / 2);
        $posY = round(($_board->height - 3) / 2);

        if ($_options->getOption("PosX") != null && $_options->getOption("PosX") < $_board->width)
        {
            $posX = $_options->getOption("PosX");
        }
        if ($_options->getOption("PosY") != null && $_options->getOption("PosY") < $_board->height)
        {
            $posY = $_options->getOption("PosY");
        }

        $_board->setField($posX + 1, $posY + 0, true);
        $_board->setField($posX + 2, $posY + 1, true);
        $_board->setField($posX + 0, $posY + 2, true);
        $_board->setField($posX + 1, $posY + 2, true);
        $_board->setField($posX + 2, $posY + 2, true);
    }

    /**
     * Add available options
     *
     * available options:
     * -PosX
     * -PosY
     *
     * @param GetOpt $_options
     */
    function addOptions(GetOpt $_options)
    {
        $_options->addOptions(array(
            array(null, "PosX", GetOpt::REQUIRED_ARGUMENT, "GliderInput - Legt die X Position des Gliders fest. Standard: Mittig"),
            array(null, "PosY", GetOpt::REQUIRED_ARGUMENT, "GliderInput - Legt die Y Position des Gliders fest. Standard: Mitiig\n"),
        ));
    }
}