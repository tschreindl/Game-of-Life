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
 * Rule 1357/1357.
 *
 * @package Rule
 */
class CopyRule extends BaseRule
{
    public function __construct()
    {
        $this->birthRule = array(1,3,5,7);
        $this->dieRule = array(0,2,4,6,8);
    }
}