<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

use GameOfLife\Board;
use Output\JPEGOutput;
use PHPUnit\Framework\TestCase;

require_once "GetOptMock.php";

/**
 * Tests that the class JPEGOutput works as expected.
 */
class JPEGOutputTest extends TestCase
{
    function testStartOutput()
    {
        $options = new GetOptMock();
        $JPEGOutput = new JPEGOutput();
        $JPEGOutput->startOutput($options->createOpt());
        $this->expectOutputString("JPEG Dateien werden erzeugt. Bitte warten...\n");
        $this->assertNotEmpty($JPEGOutput);
    }

    function testOutputBoard()
    {
        $this->assertTrue(true);
        $board = new Board(20, 20);
        $board->initEmpty();
        $options = new GetOptMock();
        $JPEGOutput = new JPEGOutput();
        $JPEGOutput->startOutput($options->createOpt());
        $JPEGOutput->outputBoard($board, $options->createOpt());
        $this->expectOutputString("JPEG Dateien werden erzeugt. Bitte warten...\n\rAktuelle Generation: 1");
        $this->assertFileExists($JPEGOutput->path . "\\1.jpeg");
        unlink($JPEGOutput->path . "\\1.jpeg");
        rmdir($JPEGOutput->path);
    }

    function testFinishOutput()
    {
        $JPEGOutput = new JPEGOutput();
        $options = new GetOptMock();

        $JPEGOutput->finishOutput($options->createOpt());
        $this->expectOutputString("\nJPEG Dateien wurden erzeugt.\n");
    }

    function testAddOptions()
    {
        $JPEGOutput = new JPEGOutput();
        $options = new GetOptMock();
        $JPEGOutput->addOptions($options->createOpt());
        $this->assertNotEmpty($JPEGOutput);
    }

}
