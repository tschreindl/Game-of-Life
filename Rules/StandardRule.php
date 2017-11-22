<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

namespace Rule;

/**
 * Class for Standard Conway Rule.
 * Rule 23/3
 *
 * @package Rule
 */
class StandardRule extends BaseRule
{
    public function __construct()
    {
        $this->birthRule = array(3);
        $this->dieRule = array(0, 1, 4, 5, 6, 7, 8);
    }
}