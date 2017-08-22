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
 * Class GliderGun
 *
 * @package Input
 */
class GliderGun extends BaseInput
{
    /**Fills the board with a Generation called Glider Gun
     *
     * @param Board $_board
     * @param GetOpt $_options
     */
    function fillBoard($_board, $_options)
    {
        $_board->setField(1, 5, true);
        $_board->setField(2, 5, true);
        $_board->setField(1, 6, true);
        $_board->setField(2, 6, true);
        $_board->setField(13, 3, true);
        $_board->setField(14, 3, true);
        $_board->setField(12, 4, true);
        $_board->setField(16, 4, true);
        $_board->setField(11, 5, true);
        $_board->setField(17, 5, true);
        $_board->setField(11, 6, true);
        $_board->setField(15, 6, true);
        $_board->setField(17, 6, true);
        $_board->setField(18, 6, true);
        $_board->setField(11, 7, true);
        $_board->setField(17, 7, true);
        $_board->setField(12, 8, true);
        $_board->setField(16, 8, true);
        $_board->setField(13, 9, true);
        $_board->setField(14, 9, true);
        $_board->setField(21, 3, true);
        $_board->setField(21, 4, true);
        $_board->setField(21, 5, true);
        $_board->setField(22, 3, true);
        $_board->setField(22, 4, true);
        $_board->setField(22, 5, true);
        $_board->setField(23, 2, true);
        $_board->setField(25, 1, true);
        $_board->setField(25, 2, true);
        $_board->setField(23, 6, true);
        $_board->setField(25, 6, true);
        $_board->setField(25, 7, true);
        $_board->setField(35, 3, true);
        $_board->setField(35, 4, true);
        $_board->setField(36, 3, true);
        $_board->setField(36, 4, true);
    }

    /**
     * Add available options
     * @param $_options
     */
    function addOptions($_options)
    {

    }
}