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
     * Function to set a custom defined rule.
     *
     * @param String $_rule
     */
    function setRule(String $_rule)
    {
        $this->birthRule = null;
        $this->dieRule = array(0, 1, 2, 3, 4, 5, 6, 7, 8);
        if (!stristr($_rule, "/")) die("Regel nicht gültig!");
        $explode = explode("/", $_rule);
        if (!is_numeric($explode[0]) || !is_numeric($explode[1])) die("Nur Zahlen von 0-8 erlaubt!");
        $split = str_split($explode[1]);
        foreach ($split as $char)
        {
            if ((int)$char > 8) die("Nur Zahlen von 0-8 gültig!");
            $this->birthRule[] = $char;
        }
        $split = str_split($explode[0]);
        foreach ($split as $char)
        {
            $search = array_search($char, $this->dieRule);
            if ($search !== false) unset($char, $this->dieRule[$search]);
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