<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

use GameOfLife\Board;
use Output\VideoOutput;
use PHPUnit\Framework\TestCase;

require_once "GetOptMock.php";

/**
 * Tests that the class VideoOutput works as expected.
 */
class VideoOutputTest extends TestCase
{
    function testStartOutput()
    {
        $options = new GetOptMock();
        $videoOutput = new VideoOutput();
        $videoOutput->startOutput($options->createOpt());
        $this->expectOutputString("Frames werden erzeugt. Bitte warten...\n");
        $this->assertClassHasAttribute("path", VideoOutput::class);
        $this->assertClassHasAttribute("imageCreator", VideoOutput::class);
        $this->assertClassHasAttribute("keepFrames", VideoOutput::class);
        $this->assertClassHasAttribute("generation", VideoOutput::class);
        $this->assertFileExists($videoOutput->path);
    }

    function testOutputBoard()
    {
        $board = new Board(20, 20);
        $options = new GetOptMock();
        $videoOutput = new VideoOutput();
        $videoOutput->startOutput($options->createOpt());
        $videoOutput->outputBoard($board, $options->createOpt());
        $this->expectOutputString("Frames werden erzeugt. Bitte warten...\n\rAktuelle Generation: 1");
        $this->assertFileExists($videoOutput->path . "0001.png");
    }

    function testFinishOutput()
    {
        $board = new Board(20, 20);
        $options = new GetOptMock();
        $videoOutput = new VideoOutput();
        $videoOutput->startOutput($options->createOpt());
        $videoOutput->outputBoard($board, $options->createOpt());
        $videoOutput->finishOutput($options->createOpt());
        if (strtoupper(substr(PHP_OS, 0, 3)) === "WIN")
        {
            $this->assertFileExists($videoOutput->path . "/../GOL.avi");
        }
        else
        {
            $this->assertFileNotExists($videoOutput->path . "/../GOL.avi");
        }

    }

    function testAddOptions()
    {
        $options = new GetOptMock();
        $videoOutput = new VideoOutput();
        $videoOutput->addOptions($options->createOpt());
        $this->assertNotEmpty($videoOutput);
    }
}
