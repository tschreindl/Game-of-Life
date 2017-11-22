<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

namespace Rule;

use GameOfLife\Field;
use UlrichSG\GetOpt;

/**
 * Base Class for all Rules.
 *
 * @package Rule
 */
class BaseRule
{
    protected $birthRule;
    protected $dieRule;

    /**
     * Calculates the new state (dead/alive) of the given field.
     *
     * @param Field $_field
     * @return bool
     */
    function calculateNewState(Field $_field)
    {
        $livingNeighbours = $_field->livingNeighbours();
        if ($_field->isAlive())
        {
            foreach ($this->dieRule as $die)
            {
                if ($livingNeighbours == $die) return false;
            }
            return true;
        }
        else
        {
            foreach ($this->birthRule as $birth)
            {
                if ($livingNeighbours == $birth) return true;
            }
            return false;
        }
    }

    /**
     * Add available options.
     *
     * @param GetOpt $_options
     */
    function addOptions(GetOpt $_options)
    {
    }
}