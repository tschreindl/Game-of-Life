<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

namespace Rule;

/**
 * Class for custom Rule.
 * Rule 12345/3
 *
 * @package Rule
 */
class LabyrinthRule extends BaseRule
{
    public function __construct()
    {
        $this->birthRule = array(3);
        $this->dieRule = array(0, 6, 7, 8);
    }
}