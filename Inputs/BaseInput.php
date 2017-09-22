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
 * Class BaseInput
 *
 * @package GameOfLife\Inputs
 */
class BaseInput
{
    function fillBoard(Board $_board, GetOpt $_options)
    {
    }

    function addOptions(GetOpt $_options)
    {
    }
}