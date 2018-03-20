<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

require_once __DIR__ . "/../vendor/autoload.php";

use Ulrichsg\Getopt;

/**
 * Class to mock options so they can be used to test classes where they needed.
 * The options that are already set under is to prevent that GetOpt fails because the options not declared, when PHPUnit use these parameter.
 */
class GetOptMock
{
    function createOpt()
    {
        $options = new GetOpt(array(
            array(null, "test", GetOpt::NO_ARGUMENT),
            array(null, "no-configuration", GetOpt::OPTIONAL_ARGUMENT),
            array(null, "teamcity", GetOpt::OPTIONAL_ARGUMENT),
            array(null, "coverage-clover", GetOpt::OPTIONAL_ARGUMENT),
            array(null, "configuration", GetOpt::OPTIONAL_ARGUMENT),
            array(null, "bootstrap", GetOpt::OPTIONAL_ARGUMENT)
        ));
        $options->parse();
        return $options;
    }

}