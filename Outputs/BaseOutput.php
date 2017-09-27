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
 * Base Class for all outputs
 *
 * @package Output
 */
class BaseOutput
{
    /**
     * Code that runs before the Board Output starts
     * Check if options given
     *
     * @param $_options
     */
    function startOutput(GetOpt $_options)
    {
    }

    /**
     * Starts the Board Output
     * Check if options given
     *
     * @param Board $_board
     * @param GetOpt $_options
     */
    function outputBoard(Board $_board, GetOpt $_options)
    {
    }

    /**
     * Code that runs after the Board Output
     * Check if options given
     *
     * @param GetOpt $_options
     */
    function finishOutput(GetOpt $_options)
    {
    }

    /**
     * Add available options
     *
     * @param GetOpt $_options
     */
    function addOptions(GetOpt $_options)
    {
    }
}