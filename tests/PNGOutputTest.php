<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

use GameOfLife\Board;
use Output\PNGOutput;
use PHPUnit\Framework\TestCase;

require_once "GetOptMock.php";

/**
 * Tests that the class PNGOutput works as expected.
 */
class PNGOutputTest extends TestCase
{
    function testStartOutput()
    {
        $options = new GetOptMock();
        $PNGOutput = new PNGOutput();
        $PNGOutput->startOutput($options->createOpt());
        $this->expectOutputString("PNG Dateien werden erzeugt. Bitte warten...\n");
        $this->assertNotEmpty($PNGOutput);
    }

    function testOutputBoard()
    {
        $this->assertTrue(true);
        $board = new Board(20, 20);
        $board->initEmpty();
        $options = new GetOptMock();
        $PNGOutput = new PNGOutput();
        $PNGOutput->startOutput($options->createOpt());
        $PNGOutput->outputBoard($board, $options->createOpt());
        $this->expectOutputString("PNG Dateien werden erzeugt. Bitte warten...\n\rAktuelle Generation: 1");
        $this->assertFileExists($PNGOutput->path . "\\1.png");
        unlink($PNGOutput->path . "\\1.png");
        rmdir($PNGOutput->path);
    }

    function testFinishOutput()
    {
        $PNGOutput = new PNGOutput();
        $options = new GetOptMock();

        $PNGOutput->finishOutput($options->createOpt());
        $this->expectOutputString("\nPNG Dateien wurden erzeugt.\n");
    }

    function testAddOptions()
    {
        $PNGOutput = new PNGOutput();
        $options = new GetOptMock();
        $PNGOutput->addOptions($options->createOpt());
        $this->assertNotEmpty($PNGOutput);
    }
}
