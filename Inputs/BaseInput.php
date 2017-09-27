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
 * Base Class for all Inputs
 *
 * @package GameOfLife\Inputs
 */
class BaseInput
{
    /**
     * Fills the given Board
     *
     * @param Board $_board
     * @param GetOpt $_options
     */
    function fillBoard(Board $_board, GetOpt $_options)
    {
    }

    /**
     * Adds available options
     *
     * @param GetOpt $_options
     */
    function addOptions(GetOpt $_options)
    {
    }
}