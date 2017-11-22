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
 * Rule 245/3.
 *
 * @package Rule
 */
class Two45Rule extends BaseRule
{
    public function __construct()
    {
        $this->birthRule = array(3);
        $this->dieRule = array(0, 1, 3, 6, 7, 8);
    }
}