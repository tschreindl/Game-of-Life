<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

use GameOfLife\Board;
use Input\BaseInput;
use PHPUnit\Framework\TestCase;

require_once "GetOptMock.php";

/**
 * Class BaseInputTest
 */
class BaseInputTest extends TestCase
{
    function testFillBoard()
    {
        $board = new Board(20,20);
        $baseInput = new BaseInput();
        $options = new GetOptMock();
        $baseInput->fillBoard($board, $options->createOpt());
        $this->assertNotEmpty($baseInput);
    }

    function testAddOptions()
    {
        $baseInput = new BaseInput();
        $options = new GetOptMock();
        $baseInput->addOptions($options->createOpt());
        $this->assertNotEmpty($baseInput);
    }
}
