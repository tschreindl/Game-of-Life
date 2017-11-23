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
 * Rule 0123/01234
 *
 * @package Rule
 */
class StainWorldRule extends BaseRule
{
    public function __construct()
    {
        $this->birthRule = array(0, 1, 2, 3, 4);
        $this->dieRule = array(4, 5, 6, 7, 8);
    }
}