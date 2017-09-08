<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

use Output\BaseOutput;
use PHPUnit\Framework\TestCase;

require_once "GetOptMock.php";
require_once __DIR__."/../Outputs/BaseOutput.php";
require_once __DIR__."/../Board.php";

/**
 * Class BaseOutputTest
 */
class BaseOutputTest extends TestCase
{
    function testStartOutput()
    {
        $options = new GetOptMock();
        $baseOutput = new BaseOutput();
        $baseOutput->startOutput($options->createOpt());
        $this->assertNotEmpty($baseOutput);
    }

    function testOutputBoard()
    {
        $board = new \GameOfLife\Board(20,20);
        $options = new GetOptMock();
        $baseOutput = new BaseOutput();
        $baseOutput->outputBoard($board, $options->createOpt());
        $this->assertNotEmpty($baseOutput);
    }

    function testFinishOutput()
    {
        $options = new GetOptMock();
        $baseOutput = new BaseOutput();
        $baseOutput->finishOutput($options->createOpt());
        $this->assertNotEmpty($baseOutput);
    }

    function testAddOptions()
    {
        $options = new GetOptMock();
        $baseOutput = new BaseOutput();
        $baseOutput->addOptions($options->createOpt());
        $this->assertNotEmpty($baseOutput);
    }
}

