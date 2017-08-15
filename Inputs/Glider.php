<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

namespace Input;

use UlrichSG\GetOpt;

/**
 * Class Glider
 *
 * @package GameOfLife\Inputs
 */
class Glider extends BaseInput
{
    /**Fills the board and set available options
     * Overwrites method from Class BaseInput
     * @param $_board
     * @param $_options
     */
    function fillBoard($_board, $_options)
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
     * @param $_options
     */
    function addOptions($_options)
    {
        $_options->addOptions(array(
            array(null, "PosX", GetOpt::REQUIRED_ARGUMENT),
            array(null, "PosY", GetOpt::REQUIRED_ARGUMENT),
        ));
    }
}